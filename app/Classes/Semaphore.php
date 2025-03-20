<?php

namespace App\Classes;

use Illuminate\Support\Facades\Http;

class Semaphore {
    private static $normalMessageApi = 'https://api.semaphore.co/api/v4/messages';
    private static $priorityMessageApi = 'https://api.semaphore.co/api/v4/priority';

    public static function send($number, $message) {
        if(config('semaphore.semaphore_env') !== 'production') return;

        $response = Http::post(self::$normalMessageApi, [
            'apikey' => config('semaphore.api_key'),
            'number' => $number,
            'message' => $message
        ]);
        $responseBody = collect(json_decode($response->body())[0]);
        //check if response success
        if($response->status() == 200 && $responseBody->has('message_id')) {
            return (object) collect([
                'status' => 200,
                'body' => $responseBody
            ]);
        }else {
            return (object) collect([
                'status' => 403,
                'errors' => $responseBody
            ]);
        }
    }
}
