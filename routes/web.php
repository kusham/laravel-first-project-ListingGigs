<?php

use App\Http\Controllers\ListingController;
use App\Http\Controllers\userController;
use App\Models\Listing;
use Illuminate\Routing\Route as RoutingRoute;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// all listing
Route::get('/', [ListingController::class, "index"]);

Route::get("/listings/create", [ListingController::class, "create"])->middleware('auth');
Route::post("/listings", [ListingController::class, "store"])->middleware('auth');
// single listing

Route::get("/listings/{listing}/edit", [ListingController::class, "edit"])->middleware('auth');
Route::put("/listings/{listing}", [ListingController::class , 'update'])->middleware('auth');
Route::delete("/listings/{listing}", [ListingController::class , 'destroy'])->middleware('auth');
Route::get("/listings/manage", [ListingController::class , 'manage'])->middleware('auth');
Route::get("/listings/{listing}", [ListingController::class , 'show']);

Route::get("/register", [userController::class , 'create'])->middleware('guest');
Route::post("/user", [userController::class , 'store'])->middleware('guest');

Route::get("/login", [userController::class , 'login'])->name('login')->middleware('guest');
Route::post("/users/authenticate", [userController::class, "authenticate"]);
Route::post("/logout", [userController::class , 'logout'])->middleware('auth');
