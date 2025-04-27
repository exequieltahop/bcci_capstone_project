<?php

namespace App\Http\Controllers;

use App\Actions\User\{UserClocksIn, UserClocksOut};
use App\Models\Entry;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class EntryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(auth()->user()->role->name == "admin"){
            $entries = Entry::all();
        }else{
            $entries = Entry::where('user_id', Auth::id())
                ->orderBy('clock_in', 'desc')
                ->paginate(10);
        }

        // dd($entries);
        return view('entries.index', compact('entries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $entry = Entry::create();

        return $entry;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function clockIn(UserClocksIn $clockIn)
    {
        $clockIn->execute(Auth::user());

        return redirect()->route('dashboard');
    }

    public function clockOut(UserClocksOut $clockOut)
    {
        $clockOut->execute(Auth::user());

        return redirect()->route('dashboard');
    }

    public function checkHasRecord()
    {
        $entry = Entry::whereDate('clock_in', Carbon::today())
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->first();

        $state = (isset($entry) && empty($entry->clock_out)) ? 'clock out' : 'clock in';

        return response()->json(['success' => true, 'state' => $state]);
    }


    public function clockInApi(Request $request, UserClocksIn $clockIn)
    {
        $entry = $clockIn->execute(Auth::user());

        return response()->json(['success' => true, 'entry' => ['clock_in' => $entry->clock_in->format('d-M-Y h:i a'), 'clock_out' => $entry->clock_out?->format('d-M-Y h:i a')]]);
    }

    public function clockOutApi(Request $request, UserClocksOut $clockOut)
    {
        $entry = $clockOut->execute(Auth::user(), ['clock_out' => Carbon::now()]);

        if (!$entry) {
            return response()->json(['success' => false]);
        }

        return response()->json(['success' => true, 'entry' => ['clock_in' => $entry->clock_in->format('d-M-Y h:i a'), 'clock_out' => $entry->clock_out?->format('d-M-Y h:i a')]]);
    }

    public function biometricLogin(Request $request)
    {
        $user = User::where('employee_code', $request->employee_code)->first();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Employee not found!']);
        }

        $entry = Entry::whereDate('clock_in', Carbon::today())
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->first();

        $state = (isset($entry) && empty($entry?->clock_out)) ? 'clock out' : 'clock in';

        if ($state == 'clock out') {
            $entry = (new UserClocksOut)->execute($user, ['clock_out' => Carbon::now()]);
        } else {
            $entry = (new UserClocksIn)->execute($user);
        }

        $entry->refresh();

        return response()->json(['success' => true, 'entry' => ['name' => $user->fullName, 'clock_in' => $entry?->clock_in->format('d-M-Y h:i a'), 'clock_out' => $entry->clock_out?->format('d-M-Y h:i a')]]);
    }


    // VIEW EMPLOYEES TIMESHEETS
}
