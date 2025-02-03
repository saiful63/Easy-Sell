<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Middleware\VerifyWebToken;
use App\Http\Middleware\SessionAuthMiddleware;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SaleReportController;
use Inertia\Inertia;

Route::get('/', function () {
   return Inertia::render('HomePage');
});

//Route to get user pages
Route::get('/RegistrationPage',[UserController::class,'RegistrationPage'])->name('RegistrationPage');
Route::get('/LoginPage',[UserController::class,'LoginPage'])->name('LoginPage');
Route::get('/SendOtpPage',[UserController::class,'SendOtpPage'])->name('SendOtpPage');
Route::get('/VerifyOtpPage',[UserController::class,'VerifyOtpPage'])->name('VerifyOtpPage');
Route::get('/ResetPasswordPage',[UserController::class,'ResetPasswordPage'])->name('ResetPasswordPage');
Route::get('/DashboardPage',[DashboardController::class,'DashboardPage'])->name('DashboardPage')->middleware([SessionAuthMiddleware::class]);
Route::get('/CategoryPage',[CategoryController::class,'CategoryPage'])->name('CategoryPage')->middleware([SessionAuthMiddleware::class]);
Route::get('/CustomerPage',[CustomerController::class,'CustomerPage'])->name('CustomerPage')->middleware([SessionAuthMiddleware::class]);
Route::get('/ProductPage',[ProductController::class,'ProductPage'])->name('ProductPage')->middleware([SessionAuthMiddleware::class]);
Route::get('/Logout',[UserController::class,'Logout'])->name('Logout');
Route::get('/ProfilePage',[UserController::class,'ProfilePage'])->name('ProfilePage')->middleware([SessionAuthMiddleware::class]);
Route::get('/CategorySavePage',[CategoryController::class,'CategorySavePage'])->name('CategorySavePage')->middleware([SessionAuthMiddleware::class]);
Route::get('/CustomerSavePage',[CustomerController::class,'CustomerSavePage'])->name('CustomerSavePage')->middleware([SessionAuthMiddleware::class]);
Route::get('/ProductSavePage',[ProductController::class,'ProductSavePage'])->name('ProductSavePage')->middleware([SessionAuthMiddleware::class]);
Route::get('/SalePage',[ProductController::class,'SalePage'])->name('SalePage')->middleware([SessionAuthMiddleware::class]);
Route::get('/ProductSavePage',[ProductController::class,'ProductSavePage'])->name('ProductSavePage')->middleware([SessionAuthMiddleware::class]);
Route::get('/InvoicePage',[InvoiceController::class,'InvoicePage'])->name('InvoicePage')->middleware([SessionAuthMiddleware::class]);



//User
Route::post('/user-registration',[UserController::class,'UserRegistration']);
Route::post('/user-login',[UserController::class,'UserLogin']);
Route::post('/sent-otp',[UserController::class,'SentOtp']);
Route::post('/verify-otp',[UserController::class,'VerifyOtp']);
Route::post('/reset-password',[UserController::class,'ResetPassword']);
Route::post('/update-profile',[UserController::class,'UpdateProfile'])->middleware([SessionAuthMiddleware::class]);

//Category
Route::post('/create-category',[CategoryController::class,'createCategory'])->name('createCategory')->middleware([SessionAuthMiddleware::class]);
Route::get('/delete-category/{id}',[CategoryController::class,'deleteCategory'])->name('deleteCategory')->middleware([SessionAuthMiddleware::class]);
Route::post('/update-category',[CategoryController::class,'updateCategory'])->name('updateCategory')->middleware([SessionAuthMiddleware::class]);
Route::get('/list-category',[CategoryController::class,'listCategory'])->name('listCategory')->middleware([SessionAuthMiddleware::class]);


//Customer
Route::post('/create-customer',[CustomerController::class,'createCustomer'])->name('createCustomer')->middleware([SessionAuthMiddleware::class]);
Route::get('/delete-customer/{id}',[CustomerController::class,'deleteCustomer'])->name('deleteCustomer')->middleware([SessionAuthMiddleware::class]);
Route::post('/update-customer',[CustomerController::class,'updateCustomer'])->name('updateCustomer')->middleware([SessionAuthMiddleware::class]);


//Product
Route::post('/create-product',[ProductController::class,'createProduct'])->name('createProduct')->middleware([SessionAuthMiddleware::class]);
Route::get('/delete-product/{id}',[ProductController::class,'deleteProduct'])->name('deleteProduct')->middleware([SessionAuthMiddleware::class]);
Route::post('/update-product',[ProductController::class,'updateProduct'])->name('updateProduct')->middleware([SessionAuthMiddleware::class]);


//Invoice
Route::post('/CreateInvoice',[InvoiceController::class,'CreateInvoice'])->name('CreateInvoice')->name('createCustomer')->middleware([SessionAuthMiddleware::class]);
Route::get('/SelectInvoice',[InvoiceController::class,'SelectInvoice'])->name('SelectInvoice')->middleware([VerifyWebToken::class]);
Route::get('/InvoiceDetail',[InvoiceController::class,'InvoiceDetail'])->name('InvoiceDetail')->middleware([SessionAuthMiddleware::class]);
Route::post('/DeleteInvoice',[InvoiceController::class,'DeleteInvoice'])->name('DeleteInvoice')->middleware([SessionAuthMiddleware::class]);
Route::get('/InvoiceList',[InvoiceController::class,'InvoiceList'])->name('InvoiceList')->middleware([SessionAuthMiddleware::class]);


//Dashboard
Route::get('/Summary',[DashboardController::class,'Summary'])->name('Summary')->middleware([VerifyWebToken::class]);

//Sale
Route::get('/list-customer',[SaleController::class,'listCustomer'])->name('listCustomer')->middleware([SessionAuthMiddleware::class]);
Route::get('/list-product',[SaleController::class,'listProduct'])->name('listProduct')->middleware([SessionAuthMiddleware::class]);

//Report
Route::get('/SaleReportPage',[SaleReportController::class,'SaleReportPage'])->name('SaleReportPage')->middleware([SessionAuthMiddleware::class]);
Route::get('/GenerateReport',[SaleReportController::class,'GenerateReport'])->name('GenerateReport')->middleware([SessionAuthMiddleware::class]);

