<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminAccessController;
use App\Http\Controllers\Admin\SettingController;

Route::middleware(['guest:admin'])->group(function () {

    Route::get('login', [AuthController::class, 'viewLogin'])
        ->name('view.login');
        
    Route::post('login', [AuthController::class, 'handleLogin'])
        ->name('handle.login');

    Route::get('/forgot-password', [AuthController::class, 'viewForgotPassword'])
        ->name('view.forgot.password');
    Route::post('/forgot-password', [AuthController::class, 'handleForgotPassword'])
        ->name('handle.forgot.password');

    Route::get('/reset-password/{token}', [AuthController::class, 'viewResetPassword'])
        ->name('view.reset.password');
    Route::post('/reset-password/{token}', [AuthController::class, 'handleResetPassword'])
        ->name('handle.reset.password');
});

Route::middleware(['auth:admin'])->group(function () {

    Route::post('logout', function () {
        Auth::logout();
        return redirect()->route('admin.view.login');
    })->name('handle.logout');

    Route::get('dashboard', [DashboardController::class, 'viewDashboard'])
        ->name('view.dashboard');

    Route::prefix('access')->controller(AdminAccessController::class)->group(function () {
        Route::get('/', 'viewAdminAccessList')
            ->name('view.access.list');
        Route::get('/create', 'viewAdminAccessCreate')
            ->name('view.access.create');
        Route::get('/update/{id}', 'viewAdminAccessUpdate')
            ->name('view.access.update');
        Route::post('/create', 'handleAdminAccessCreate')
            ->name('handle.access.create');
        Route::post('/update/{id}', 'handleAdminAccessUpdate')
            ->name('handle.access.update');
        Route::put('/status', 'handleToggleAdminAccessStatus')
            ->name('handle.access.status');
        Route::get('/delete/{id}', 'handleAdminAccessDelete')
            ->name('handle.access.delete');
    });

    Route::prefix('setting')->controller(SettingController::class)->group(function () {
        Route::get('/', 'viewSetting')
            ->name('view.setting');
        Route::get('/account-information', 'viewAccountSetting')
            ->name('view.setting.account');
        Route::post('/account-information', 'handleAccountSetting')
            ->name('handle.setting.account');
        Route::get('/update-password', 'viewPasswordSetting')
            ->name('view.setting.password');
        Route::post('/update-password', 'handlePasswordSetting')
            ->name('handle.setting.password');

        Route::get('/roles-permissions', 'viewRolePermission')
            ->name('view.setting.role.permission');
        Route::get('/role/create', 'viewRoleCreate')
            ->name('view.setting.role.create');
        Route::post('/role/create', 'handleRoleCreate')
            ->name('handle.setting.role.create');
        Route::get('/role/update/{id}', 'viewRoleUpdate')
            ->name('view.setting.role.update');
        Route::post('/role/update/{id}', 'handleRoleUpdate')
            ->name('handle.setting.role.update');
        Route::get('/role/remove/permission/{role_id}/{permission_id}', 'handleRemovePermission')
            ->name('view.setting.role.remove.permission');
    });
});