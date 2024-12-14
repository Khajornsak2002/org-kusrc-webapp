<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DocumentReceivingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminLoginController;

// เส้นทางที่ผู้ดูแลระบบ (admin) เข้าถึงได้
// Route::get('/home-admin', function () {
//     return view('admins.home-admin');
// })->name('home-admin')->middleware(['auth', 'admin']);

// Route::group(['middleware' => ['auth', 'admin']], function () {
//     Route::get('/admin/home', function () {
//         return view('admins.home-admin');
//     })->name('admin.home');
// });

// เส้นทางที่ผู้ใช้ทั่วไป (guest) เข้าถึงได้
Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('home');
})->name('home');

Route::get('/user/image/{id}', [AuthController::class, 'getImage'])->name('user.image');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');

Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');

Route::get('/documents', [DocumentController::class, 'index'])->name('documents.index');
Route::post('/documents', [DocumentController::class, 'store'])->name('documents.store');

Route::get('/document-receiving', [DocumentReceivingController::class, 'index'])->name('document-receiving.index');
Route::post('/documents/update-status', [DocumentController::class, 'updateStatus']);
Route::post('/documents/update-checkbox-status', [DocumentReceivingController::class, 'updateCheckboxStatus']);

Route::get('/check-student-id', function () {
    return view('student-check.student-check');
});

Route::get('/api/documents', [DocumentController::class, 'apiIndex'])->name('api.documents.index');
// Route::get('/api/documents-spa', [DocumentController::class, 'apidocumentspa'])->name('api.documents.index');

// Add route for admin login
Route::get('/admin/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.submit');

// Apply AdminMiddleware to the admin home route
Route::group(['middleware' => ['auth', 'admin']], function () {
    Route::get('/admin/home', [AdminController::class, 'index'])->name('admin.home-admin');
});

// Add route for organization structure
Route::get('/organization-structure', function () {
    return view('structure-org.structure-org');
})->name('organization.structure');

// Add route for borrow-return
Route::get('/borrow-return', function () {
    return view('borrow-return.borrow-return');
})->name('borrow-return');
