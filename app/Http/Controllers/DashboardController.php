<?php

namespace App\Http\Controllers;

use App\Models\Entry;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Types\Relations\Car;

class DashboardController extends Controller
{
    public function index()
    {
        $entry = Entry::whereDate('clock_in', Carbon::today())
            ->where('user_id', Auth::id())
            ->orderBy('clock_in', 'desc')
            ->first();

        // GET TODAY LOGIN
        $today_login = DB::table('entries')
            ->whereYear('clock_in', Carbon::now()->year)
            ->whereMonth('clock_in', Carbon::now()->month)
            ->whereDay('clock_in', Carbon::now()->day)
            ->get()
            ->count();
        
        $state              = (isset($entry) && empty($entry->clock_out)) ? 'clock out' : 'clock in';
        $hasClockedOutToday = !empty($entry->clock_out);

        return view('dashboard', compact('entry', 'state', 'hasClockedOutToday', 'today_login'));
    }
}
