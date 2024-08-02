<?php
use App\Jobs\AttendanceJob;

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\UserLeaveController;
use App\Http\Controllers\WorkersController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;


Route::get('/dashboard',[DashboardController::class,'index'])->middleware('auth')->can('viewAny','App\\Models\User');

//registerroute
Route::get('/register',[RegisteredUserController::class,'create']);
Route::post('/register',[RegisteredUserController::class,'store'])->name('register.store');
Route::post('/login',[SessionController::class,'store']);
Route::get('/',[SessionController::class,'create'])->name('login');
Route::get('/logout',[SessionController::class,'destroy']);
Route::get('/dashboardprofile/{user}',[SessionController::class,'show']);
Route::patch('/dashboardprofile/{user}',[SessionController::class,'update']);
Route::patch('/dashboardprofile/{user}/suspend',[SessionController::class,'suspend']);
Route::get('/dashboard/count',[DashboardController::class,'getWorkerCount']);
Route::get('/dashboard/countpresent',[DashboardController::class,'getPresentWorkerCount']);
Route::get('/dashboard/activeworker',[DashboardController::class,'getWorkerStatus']);
//department count
Route::get('/dashboard/departmentcount',[DashboardController::class,'departmentTotal']);
Route::get('/dashboard/departmentactivecount',[DashboardController::class,'departmentStatuscount']);
Route::delete('/dashboardprofile/{user}',[SessionController::class,'delete'])->middleware('auth')
->can('create',User::class);

//change password
Route::post('/dashboardprofile/{user}/changepassword',[PasswordController::class,'changePassword'])->middleware('auth');
//workers route
Route::get('/workers',[WorkersController::class,'index'])->middleware('auth');
Route::get('/workers/staff',[WorkersController::class,'staff'])->middleware('auth');
Route::get('/workers/admin',[WorkersController::class,'admin'])->middleware('auth');
Route::get('/workers/register',[DashboardController::class,'create'])->middleware('auth')->can('create',User::class);
Route::get('/search',SearchController::class)->name('search');
Route::get('/search/staff',[WorkersController::class,'staffSearch'])->name('search.staff');
Route::get('/search/admin',[WorkersController::class,'adminSearch'])->name('search.admin');
Route::get('/worker/salary/{user}',[WorkersController::class,'workerSalary'])->middleware('auth');

//departments
Route::get('/departments',[DepartmentController::class,'index'])->middleware('auth');
Route::get('/departments/{department}',[DepartmentController::class,'show'])->middleware('auth');
Route::patch('/departments/{department}',[DepartmentController::class,'update'])->middleware('auth');
Route::patch('/department/{department}/suspend',[DepartmentController::class,'suspend'])->middleware('auth');
Route::delete('/department/{department}',[DepartmentController::class,'destroy'])->middleware('auth');
Route::get('/search/department',[DepartmentController::class,'search'])->middleware('auth')->name('departments.search');
Route::post('/department',[DepartmentController::class,'store'])->middleware('auth')->can('create',User::class);
Route::get('/department/register',[DepartmentController::class,'create'])->middleware('auth')->can('create',User::class)
->name('department.register');

//attendance
Route::get('/attendance',[AttendanceController::class,'index'])->middleware('auth');
Route::get('/attendance/search',[AttendanceController::class,'search'])->middleware('auth');
Route::get('/attendance/history',[AttendanceController::class,'history'])->middleware('auth');
Route::get('/attendance/history/search',[AttendanceController::class,'searchHistory'])->middleware('auth');
Route::get('/attendance/mark',[AttendanceController::class,'create'])->middleware('auth');
Route::post('/attendance/mark/{user}',[AttendanceController::class,'checkin'])->middleware('auth');
Route::get('/attendance/staff',[AttendanceController::class,'staff'])->middleware('auth');
Route::get('/attendance/admin',[AttendanceController::class,'admin'])->middleware('auth');
Route::get('/attendance/admin/search',[AttendanceController::class,'searchforAdmin'])->middleware('auth');
Route::get('/attendance/staff/search',[AttendanceController::class,'searchforStaff'])->middleware('auth');

//leave request

Route::middleware('auth')->group(function () {
    Route::get('/leave', [UserLeaveController::class, 'index']);
    Route::get('/leave/search', [UserLeaveController::class, 'search']);
    Route::get('/leave/request', [UserLeaveController::class, 'create']);
    Route::post('/leave/request', [UserLeaveController::class, 'store']);
    Route::get('/leave/{id}', [UserLeaveController::class, 'edit']);
    Route::patch('/leave/{id}', [UserLeaveController::class, 'update']);
    Route::get('/leave/status/{user}',[UserLeaveController::class,'show']);
    Route::get('/leave/status/{user}/search',[UserLeaveController::class,'searchWorker']);
});
//salary

Route::middleware('auth')->group(function(){
    Route::get('/salary',[SalaryController::class,'index']);
    Route::get('/salary/create',[SalaryController::class,'create']);
    Route::post('/salary',[SalaryController::class,'store']);
    Route::patch('/salary/{salary}',[SalaryController::class,'update']);
    Route::get('/salary/{id}',[SalaryController::class,'edit']);
    Route::get('/salary/search',[SalaryController::class,'search'])->can('view',User::class);

});
//payroll
Route::middleware('auth')->group(function(){
    Route::get('/payroll',[PayrollController::class,'index'])->can('view',User::class);
    Route::get('/payroll/create',[PayrollController::class,'create'])->can('view',User::class);
    Route::get('/payroll/search',[PayrollController::class,'search'])->can('view',User::class);
    Route::get('/payroll/{id}',[PayrollController::class,'edit'])->can('view',User::class);
    Route::patch('/payroll/{id}',[PayrollController::class,'update'])->can('view',User::class);
    Route::get('/payrolls',[PayrollController::class,'payment'])->can('view',User::class);
    Route::post('/payroll/process-payments', [PayrollController::class, 'processPayments'])->name('payroll.process-payments');

});

Route::get('/test-attendance-job', function () {
    AttendanceJob::dispatch();
    return 'Attendance job dispatched!';
});

