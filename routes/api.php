<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Middleware\VerifyWebToken;
use App\Http\Middleware\SessionAuthMiddleware;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\InvoiceController;

Route::post('/user-registration',[UserController::class,'UserRegistration']);
Route::post('/user-login',[UserController::class,'UserLogin']);
Route::post('/sent-otp',[UserController::class,'SentOtp']);
Route::post('/verify-otp',[UserController::class,'VerifyOtp']);
Route::post('/reset-password',[UserController::class,'ResetPassword'])->middleware([VerifyApiToken::class]);
Route::get('/get-user',[UserController::class,'GetUser'])->middleware([VerifyApiToken::class]);
Route::post('/update-profile',[UserController::class,'UpdateProfile'])->middleware([VerifyWebToken::class]);



//Category
Route::post('/create-category',[CategoryController::class,'createCategory'])->name('createCategory')->middleware([VerifyWebToken::class]);
Route::get('/list-category',[CategoryController::class,'listCategory'])->name('listCategory')->middleware([VerifyWebToken::class]);
Route::post('/delete-category',[CategoryController::class,'deleteCategory'])->name('deleteCategory')->middleware([VerifyWebToken::class]);
Route::post('/update-category',[CategoryController::class,'updateCategory'])->name('updateCategory')->middleware([VerifyWebToken::class]);
Route::get('/category-by-id',[CategoryController::class,'categoryById'])->name('categoryById')->middleware([VerifyWebToken::class]);


//Customer
Route::post('/create-customer',[CustomerController::class,'createCustomer'])->name('createCustomer')->middleware([VerifyWebToken::class]);
Route::post('/list-customer',[CustomerController::class,'listCustomer'])->name('listCustomer')->middleware([VerifyWebToken::class]);
Route::post('/delete-customer',[CustomerController::class,'deleteCustomer'])->name('deleteCustomer')->middleware([VerifyWebToken::class]);
Route::post('/update-customer',[CustomerController::class,'updateCustomer'])->name('updateCustomer')->middleware([VerifyWebToken::class]);
Route::post('/customer-by-id',[CustomerController::class,'customerById'])->name('customerById')->middleware([VerifyWebToken::class]);


//Product
Route::post('/create-product',[ProductController::class,'createProduct'])->name('createProduct')->middleware([VerifyWebToken::class]);
Route::post('/list-product',[ProductController::class,'listProduct'])->name('listProduct')->middleware([VerifyWebToken::class]);
Route::post('/delete-product',[ProductController::class,'deleteProduct'])->name('deleteProduct')->middleware([VerifyWebToken::class]);
Route::post('/update-product',[ProductController::class,'updateProduct'])->name('updateProduct')->middleware([VerifyWebToken::class]);
Route::post('/product-by-id',[ProductController::class,'productById'])->name('productById')->middleware([VerifyWebToken::class]);

//Invoice
Route::post('/CreateInvoice',[InvoiceController::class,'CreateInvoice'])->name('CreateInvoice')->middleware([VerifyWebToken::class]);
Route::get('/SelectInvoice',[InvoiceController::class,'SelectInvoice'])->name('SelectInvoice')->middleware([VerifyWebToken::class]);
Route::get('/InvoiceDetail',[InvoiceController::class,'InvoiceDetail'])->name('InvoiceDetail')->middleware([VerifyWebToken::class]);
Route::post('/DeleteInvoice',[InvoiceController::class,'DeleteInvoice'])->name('DeleteInvoice')->middleware([VerifyWebToken::class]);

//Dashboard
Route::get('/Summary',[DashboardController::class,'Summary'])->name('Summary')->middleware([VerifyWebToken::class]);
