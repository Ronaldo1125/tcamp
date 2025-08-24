<?php

use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PapController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TravelController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\FundSourceController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TravelOrderController;
use App\Http\Controllers\HttpLocationController;
use App\Http\Controllers\TransportationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::redirect('/', 'login');

Route::get('/testmail', [MailController::class, 'index']);


Route::group(['middleware' => 'prevent-back-history'],function(){
      
    Auth::routes([
        'verify' => true,
        'forgot-password' => true,
    ]);

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('verified');


    Route::group(['middleware' => ['auth']], function() {

        // Route::post('/travel/preview', [TravelController::class, 'preview'])->name('travel.preview');
        // Route::resource('travel', TravelController::class);
        Route::resource('roles', RoleController::class);
        Route::get('/users/viewUnapproveUsers', [UserController::class, 'viewUnapproveUsers'])->name('users.view_unapprove_users');
        Route::post('/users/approveRegistration/{id}', [UserController::class, 'approveRegistration'])->name('users.approveRegistration');
        Route::resource('users', UserController::class);
        

        // Route::get('users', [UserController::class, 'index'])->name('users.index');
        // Route::get('users/create', [UserController::class, 'create'])->name('users.create');
        // Route::get('users/destroy/{id}', [UserController::class, 'destroy'])->name('users.destroy');
        // Route::get('users/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
        // Route::get('users/store', [UserController::class, 'store'])->name('users.store');
        // Route::get('users/update/{id}', [UserController::class, 'update'])->name('users.update');
        Route::resource('divisions', DivisionController::class);
        Route::resource('designations', DesignationController::class);
        Route::resource('fund_sources', FundSourceController::class);
        Route::resource('transportations', TransportationController::class);
        Route::resource('employees', EmployeeController::class);

        Route::get('/paps/getPaps', [PapController::class, 'getPaps'])->name('paps.getPaps');

        Route::resource('paps', PapController::class);

        Route::post('/travel_orders/sendApproval/{id}', [TravelOrderController::class, 'sendApproval'])->name('travel_orders.sendApproval');
        Route::get('/travel_orders/viewTravelOrder/{id}', [TravelOrderController::class, 'viewTravelOrder'])->name('travel_orders.view_travel_order');
        Route::get('/travel_orders/viewORS/{id}', [TravelOrderController::class, 'viewORS'])->name('travel_orders.view_ors');
        Route::resource('travel_orders', TravelOrderController::class);
        
           
        // Route of travel
        //Route::resource('students', StudentController::class);

        Route::get('/getRegions', [HttpLocationController::class, 'getRegions'])->name('getRegions');
        Route::get('/getProvinces', [HttpLocationController::class, 'getProvinces']);
        Route::get('/getCities', [HttpLocationController::class, 'getCities']);
        Route::get('/getBarangays', [HttpLocationController::class, 'getBarangays']);

        Route::get('/location/provinces', [LocationController::class, 'provinces'])->name('location.provinces');
        Route::get('/location/cities', [LocationController::class, 'cities'])->name('location.cities');
        Route::get('/location/regions', [LocationController::class, 'regions'])->name('location.regions');

        //Route of Profile
        
        //Route::resource('/profiles', ProfileController::class);
        Route::get('/profiles', [ProfileController::class, 'index'])->name('profiles.index');
        //Route::put('/profiles/update/{id}', [ProfileController::class, 'update'])->name('profiles.update');
        Route::post('/profiles/update-password/{id}', [ProfileController::class, 'updatePassword'])->name('profiles.updatePassword');
        Route::get('/profiles/admin-approval', [ProfileController::class, 'adminApproval'])->name('profiles.adminApproval');
        Route::get('/profiles/change-password', [ProfileController::class, 'changePassword'])->name('profiles.changePassword');
        Route::get('/profiles/create', [ProfileController::class, 'create'])->name('profiles.create');

        Route::post('/profiles/update-pic', [ProfileController::class, 'updatePic'])->name('profiles.updatePic');
        Route::post('/profiles/update-info', [ProfileController::class, 'updateInfo'])->name('profiles.updateInfo');
        
        //Route::post('/home/markNotification', [HomeController::class, 'markNotification'])->name('home.markNotification');




        
    });

});

