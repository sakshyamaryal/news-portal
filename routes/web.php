<?php

use App\Http\Controllers\Admin\AdvertisementController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleAndPermissionController;
use App\Http\Controllers\SidebarController;
use Illuminate\Support\Facades\Route;

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



Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', [NewsController::class, 'index']);
Route::get('category/{id}', [NewsController::class, 'showCategory'])->name('category.articles');
Route::get('search', [NewsController::class, 'search'])->name('search.articles');
Route::get('/article/{id}', [NewsController::class, 'showArticle'])->name('article.show');
Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update')->middleware('auth');
Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy')->middleware('auth');



Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('settings/roles', [RoleAndPermissionController::class, 'index'])->name('roles.index');
    Route::get('settings/sidebar', [SidebarController::class, 'index'])->name('roles.index');
    Route::resource('sidebars', SidebarController::class);


    Route::prefix('roles-permissions')->name('roles_permissions.')->group(function () {
        // Role Routes
        Route::get('/', [RoleAndPermissionController::class, 'index'])->name('index');
        Route::post('store-role', [RoleAndPermissionController::class, 'storeRole'])->name('store_role');
        Route::get('edit-role/{role}', [RoleAndPermissionController::class, 'editRole'])->name('edit_role');
        Route::put('update-role/{role}', [RoleAndPermissionController::class, 'updateRole'])->name('update_role');
        Route::delete('destroy-role/{role}', [RoleAndPermissionController::class, 'destroyRole'])->name('destroyRole');
        
        // Permission Routes
        Route::post('store-permission', [RoleAndPermissionController::class, 'storePermission'])->name('store_permission');
        Route::get('edit-permission/{permission}', [RoleAndPermissionController::class, 'editPermission'])->name('edit_permission');
        Route::put('update-permission/{permission}', [RoleAndPermissionController::class, 'updatePermission'])->name('update_permission');
        Route::delete('destroy-permission/{permission}', [RoleAndPermissionController::class, 'destroyPermission'])->name('destroyPermission');
        
        // Assign Permissions to Roles
        Route::post('assign-permissions/{role}', [RoleAndPermissionController::class, 'assignPermissions'])->name('assign_permissions');
    });

    Route::get('/user-management', [UserController::class, 'index'])->name('users.index');

    Route::prefix('users')->group(function () {
        Route::get('/create', [UserController::class, 'create'])->name('users.create'); // Show form to create user
        Route::post('/', [UserController::class, 'store'])->name('users.store'); // Store new user
        Route::get('/{user}', [UserController::class, 'show'])->name('users.show'); // Show single user details
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('users.edit'); // Show form to edit user
        Route::put('/{user}', [UserController::class, 'update'])->name('users.update'); // Update user details
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('users.destroy'); // Delete user
    });

    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('/admin_categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/admin_categories/edit/{id}', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/admin_categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/admin_categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');


    Route::prefix('advertisements')->middleware('auth')->group(function() {
        Route::get('/', [AdvertisementController::class, 'index'])->name('advertisements.index');
        Route::get('create', [AdvertisementController::class, 'create'])->name('advertisements.create');
        Route::post('/', [AdvertisementController::class, 'store'])->name('advertisements.store');
        Route::get('{id}/edit', [AdvertisementController::class, 'edit'])->name('advertisements.edit');
        Route::put('{id}', [AdvertisementController::class, 'update'])->name('advertisements.update');
        Route::delete('{id}', [AdvertisementController::class, 'destroy'])->name('advertisements.destroy');
    });

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/upload-image', [ProfileController::class, 'uploadImage'])->name('profile.upload-image');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::resource('articles', ArticleController::class);
    Route::delete('/images/{image}', [ArticleController::class, 'destroyImage'])->name('images.destroy');
});
