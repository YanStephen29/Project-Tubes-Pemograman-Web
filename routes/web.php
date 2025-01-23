<?php

use App\Http\Controllers\RestaurantController;

// Halaman Welcome
Route::get('/', function () {
    return view('home.welcome');
})->name('welcome');

// Halaman Home (dengan pilihan SIGN IN dan SIGN UP)
Route::get('/home', function () {
    return view('home.home');
})->name('home');

// Pilih role
Route::get('/register/role', [RestaurantController::class, 'showSelectRole'])->name('register.role');

// Proses pemilihan role
Route::post('/register/role', [RestaurantController::class, 'processRoleSelection'])->name('select-role');

// Form registrasi berdasarkan role
Route::get('/register', [RestaurantController::class, 'showRegistrationForm'])->name('register.form');

// Proses registrasi
Route::post('/register', [RestaurantController::class, 'register'])->name('register');

// Form login
Route::get('/login', [RestaurantController::class, 'showLoginForm'])->name('login');

// Proses login
Route::post('/login', [RestaurantController::class, 'login'])->name('login.submit');

//Untuk Logout
Route::post('/logout', [RestaurantController::class, 'logout'])->name('logout');

// Untuk Hapus Akun Role Restautant
Route::delete('/restaurant/delete/{id}', [RestaurantController::class, 'deleteRestaurant'])->name('restaurant.delete');


// Beranda untuk customer
Route::get('/customer/home', function () {
    return view('customer.berandaCustomer');
})->name('customer.home')->middleware('auth');

// Beranda untuk restaurant
Route::get('/restaurant/home', function () {
    return view('resto.berandaResto');
})->name('restaurant.home')->middleware('auth');

Route::get('/restaurant/home', [RestaurantController::class, 'restaurantHome'])->name('restaurant.home')->middleware('auth');


// Route untuk redirect ke penyedia di bagian register(login with)
Route::get('/auth/redirect/{provider}', [SocialiteController::class, 'redirect'])->name('socialite.redirect');
Route::get('/auth/callback/{provider}', [SocialiteController::class, 'callback'])->name('socialite.callback');

// Route untuk CRUD product dengan role restaurant
Route::get('/restaurant/products/add', [RestaurantController::class, 'addProductForm'])->name('products.add');
Route::get('/restaurant/products/create', [RestaurantController::class, 'createProduct'])->name('products.create');
Route::post('/restaurant/products/add', [RestaurantController::class, 'storeProduct'])->name('products.store');
Route::get('/restaurant/products/edit/{id}', [RestaurantController::class, 'editProductForm'])->name('products.edit');
Route::put('/restaurant/products/update/{id}', [RestaurantController::class, 'updateProduct'])->name('products.update');
Route::delete('/restaurant/products/{id}', [RestaurantController::class, 'deleteProduct'])->name('products.destroy');
Route::post('/restaurant/products', [RestaurantController::class, 'storeProduct'])->name('products.store');

// Rute untuk memproses update profil
Route::put('/profile/update/resto', [RestaurantController::class, 'updateRestaurantProfile'])->name('profile.update.resto');
Route::put('/profile/update/customer', [RestaurantController::class, 'updateCustomerProfile'])->name('profile.update.customer');
Route::get('/editprofile-resto', [RestaurantController::class, 'editRestaurantProfile'])->name('editprofile.resto')->middleware('auth');

Route::get('/restaurant/orders', [RestaurantController::class, 'showOrders'])->name('restaurant.orders')->middleware('auth');

//Untuk show orders
Route::get('/restaurant/orders', [RestaurantController::class, 'showOrders'])->name('restaurant.orders')->middleware('auth');

//Rute untuk update profil
Route::get('/editprofile-customer', [RestaurantController::class, 'editCustomerProfile'])->name('editprofile.customer')->middleware('auth');

//Route Hapus Customer
Route::delete('/customer/delete', [RestaurantController::class, 'deleteCustomer'])->name('profile.delete.customer');
