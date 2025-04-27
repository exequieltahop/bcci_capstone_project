<?php

use App\Http\Controllers\{BenefitController, CategoryController, DashboardController, DeductionController, EmployeeController, EmployeeLeaveInformationController, EntryController, LeaveController, LeaveTypeController, OvertimeController, PositionController, ProfileController, UserController, PayrollController};
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;
use Laragear\WebAuthn\Http\Routes as WebAuthnRoutes;

Route::get('/', function () {
    return view('time_record.index');
})->middleware('guest');

Route::post('entries/biometric/login', [EntryController::class, 'biometricLogin'])->name('entries.biometric-login');
Route::post('employee/biometric/register', [EmployeeController::class, 'biometricRegister']);

WebAuthnRoutes::register()->withoutMiddleware(VerifyCsrfToken::class);

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

    Route::view('about', 'about')->name('about');

    Route::get('users', [UserController::class, 'index'])->name('users.index');

    Route::resource('employees', EmployeeController::class);
    Route::get('/employees/{employee_id}/leaves', [EmployeeController::class, 'leaves'])->name('employees.leaves');
    Route::get('/employees/{employee_id}/deductions', [EmployeeController::class, 'deductions'])->name('employees.deductions');
    Route::get('/employees/{employee}/deductions/{deduction}/edit', [EmployeeController::class, 'deduction_edit'])->name('employees.deduction-edit');
    Route::get('/employees/{employee}/deductions/create', [EmployeeController::class, 'deduction_create'])->name('employees.deduction-create');
    Route::get('/employees/{employee_id}/leaves/information/create', [EmployeeLeaveInformationController::class, 'create'])->name('employees.leave-information-create');
    Route::post('/employees/{employee_id}/leaves/information', [EmployeeLeaveInformationController::class, 'store'])->name('employees.leave-information-store');
    Route::get('/employees/{employee_id}/leaves/information/{leave_information_id}/edit', [EmployeeLeaveInformationController::class, 'edit'])->name('employees.leave-information-edit');
    Route::put('/employees/{employee_id}/leaves/information/{leave_information_id}', [EmployeeLeaveInformationController::class, 'update'])->name('employees.leave-information-update');
    Route::delete('/employees/{employee_id}/leaves/information/{leave_information_id}', [EmployeeLeaveInformationController::class, 'destroy'])->name('employees.leave-information-delete');

    Route::post('/deductions', [DeductionController::class, 'store'])->name('deductions.store');
    Route::get('/deductions/{deduction}', [DeductionController::class, 'edit'])->name('deductions.edit');
    Route::put('/deductions/{deduction}', [DeductionController::class, 'update'])->name('deductions.update');
    Route::delete('/deductions/{deduction}', [DeductionController::class, 'destroy'])->name('deductions.destroy');

    Route::get('/leaves/approval', [LeaveController::class, 'approval'])->name('leaves.approval');
    Route::post('/leaves-bulk/approve', [LeaveController::class, 'bulkApprove'])->name('leaves.bulkApprove');
    Route::resource('leaves', LeaveController::class);
    Route::get('/leaves/{leave}/cancel', [LeaveController::class, 'cancelPage'])->name('leaves.cancel-page');
    Route::patch('/leaves/{leave}/cancel', [LeaveController::class, 'cancelOperation'])->name('leaves.cancel-operation');
    Route::patch('/leaves/{leave}/approve', [LeaveController::class, 'approveOperation'])->name('leaves.approve-operation');
    Route::resource('leave-types', LeaveTypeController::class);
    Route::resource('benefits', BenefitController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('positions', PositionController::class);
    Route::resource('payrolls', PayrollController::class);


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/deductions', [DeductionController::class, 'store'])->name('deductions.store');

    Route::group(['prefix' => 'overtimes'], function () {
        Route::get('/approval', [OvertimeController::class, 'approval'])->name('overtimes.approval');
        Route::post('/{overtime}/approved', [OvertimeController::class, 'approved'])->name('overtimes.approved');
        Route::post('/{overtime}/rejected', [OvertimeController::class, 'rejected'])->name('overtimes.rejected');
    });
    Route::resource('overtimes', OvertimeController::class);

    Route::group(['prefix' => 'entries'], function () {
        # pages
        Route::get('/', [EntryController::class, 'index'])->name('entries.index');

        # forms
        Route::post('clock-in', [EntryController::class, 'clockIn'])->name('entries.clock-in');
        Route::post('clock-out', [EntryController::class, 'clockOut'])->name('entries.clock-out');

        # api
        Route::get('check-user-record', [EntryController::class, 'checkHasRecord'])->name('entries.check-user-record');
        Route::post('clock-in/api', [EntryController::class, 'clockInApi'])->name('entries.clock-in-api');
        Route::post('clock-out/api', [EntryController::class, 'clockOutApi'])->name('entries.clock-out-api');

        # Fingerprint API
    });

    // EMPLOYEES TIMESHEETS
    Route::group(['prefix' => 'employees-timesheet'], function () {
        # pages
        Route::get('/', [EntryController::class, 'index'])->name('employee-time-sheet-logs');
        Route::get('/view/{id}', [EntryController::class, 'viewEmployeeLogs'])->name('view-employee-time-sheet-logs');

    });
});


require __DIR__ . '/auth.php';
