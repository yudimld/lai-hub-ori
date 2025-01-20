<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

use App\Models\User;
use App\Http\Controllers\PpicController;
use App\Http\Controllers\SalesMarketingController;
use App\Http\Controllers\MesSpkController;
use App\Http\Controllers\EdcController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DeliveryController;

// Email
use App\Mail\Edc\CreateSPKMail;
use App\Mail\Edc\AssignSPKMail;
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
Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
Route::post('/admin/users', [AdminController::class, 'store'])->name('admin.users.store');
Route::put('/admin/users/{id}', [AdminController::class, 'update'])->name('admin.users.update');
Route::delete('/admin/users/{id}', [AdminController::class, 'destroy'])->name('admin.users.destroy');


Route::get('/', function () {
    return view('get_started');
});

Route::middleware('auth')->group(function () {
    Route::post('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password');

    Route::get('/homePage', function () {
        return view('homePage');
    });

    // Grouping untuk Sales Marketing CSR
    Route::prefix('salesmarketing/csr')
    ->name('csr.')
    ->middleware('check.role:manager_csr,spv_csr,staff_csr,staff_edc,manager_edc')
    ->group(function () {
        // Rute untuk halaman utama dan fitur CSR
        Route::get('/opportunity', [SalesMarketingController::class, 'opportunity'])->name('opportunity');
        Route::get('/so-number', [SalesMarketingController::class, 'showSoNumberPage'])->name('so-number');
        Route::post('/request-to-delivery', [SalesMarketingController::class, 'requestToDelivery'])->name('request-to-delivery');
        Route::get('/delivery/status', [SalesMarketingController::class, 'showDeliveryStatus'])->name('delivery.status');
        Route::delete('/delivery/delete/{id}', [SalesMarketingController::class, 'deleteDelivery'])->name('delivery.delete');
        Route::post('/delivery/upload-file/{id}', [SalesMarketingController::class, 'uploadFile'])->name('delivery.upload-file');
        Route::post('/ppic-eticket/update-status', [SalesMarketingController::class, 'updateStatus'])->name('ppic.update-status');

        // save to draft
        Route::post('/save-to-draft', [SalesMarketingController::class, 'saveToDraft']);

        // Rute API untuk request ke PPIC
        Route::post('/request-to-ppic', [SalesMarketingController::class, 'storePpicRequest']);
        Route::get('/api/status-request-data', [SalesMarketingController::class, 'getStatusRequestData']);

        // api edit dan delete di opportunity
        Route::put('/api/opportunity/{id}', [SalesMarketingController::class, 'updateProducts']);
        Route::delete('/api/opportunity/{id}', [SalesMarketingController::class, 'deleteOpportunity']);
        Route::get('/api/opportunity/{id}', [SalesMarketingController::class, 'getOpportunityById']);


    });



    // Menu PPIC
    Route::prefix('ppic-eticket')->group(function () {
        Route::get('/', [PpicController::class, 'index'])->name('ppic.eticket'); // Halaman utama
        Route::get('/ppic/requests', [PpicController::class, 'showPpicData'])->name('ppic.requests'); // API data SPK
        Route::post('/update-status-preparing', [PpicController::class, 'updateStatusToPreparing'])->name('ppic.update-status-preparing');
        Route::post('/ppic/revision-date', [PpicController::class, 'updateRevisionDate'])->name('revision-date');
        

        Route::post('/ppic/not-accept', [PpicController::class, 'notAcceptReason'])->name('ppic.not-accept');
        Route::post('/opportunity/{id}/update-products', [SalesMarketingController::class, 'updateProducts']);
        Route::delete('/opportunity/{id}', [SalesMarketingController::class, 'deleteOpportunity']);


    });

    // Menu Delivery
    Route::prefix('delivery-spk')->group(function () {
        Route::get('/', [DeliveryController::class, 'index'])->name('delivery.spk'); // Halaman utama SPK Delivery
        Route::get('/requests', [DeliveryController::class, 'getAllDeliveries'])->name('delivery.requests'); // API data Delivery
        Route::post('/update-status-delivery', [DeliveryController::class, 'updateStatusToDelivery'])->name('delivery.update-status-delivery');
        Route::post('/close-delivery', [DeliveryController::class, 'closeDelivery'])->name('delivery.close');
        Route::post('/{id}/update-products', [DeliveryController::class, 'updateProducts']); // Update produk tertentu
        Route::delete('/{id}', [DeliveryController::class, 'deleteDelivery']); // Hapus data Delivery
    });
    
    // menu MES SPK
    Route::prefix('mes-spk')->name('mes.spk.')->group(function () {
        Route::get('/', [MesSpkController::class, 'index'])->name('list'); // Route list SPK
        Route::get('/create', [MesSpkController::class, 'create'])->name('create'); // Route create SPK
        Route::get('/create2', [MesSpkController::class, 'create2'])->name('create2'); // Route create SPK

    });


    // Menu EDC
    Route::prefix('edc')->name('edc.')->group(function () {
        // Rute untuk manager_edc dan staff_edc
        Route::middleware('check.role:manager_edc,staff_edc')->group(function () {
            Route::get('/', [EdcController::class, 'dashboard'])->name('dashboard');
            Route::get('/assign-spk', [EdcController::class, 'assignSpk'])->name('assign-spk');
            Route::post('/assign-spk/{id}', [EdcController::class, 'assignSpkAction'])->name('assign-spk-action');
            Route::get('/list-spk', [EdcController::class, 'listSpk'])->name('list-spk'); // Akses untuk manager_edc & staff_edc
            Route::get('/filter-spk', [EdcController::class, 'filterSpk'])->name('filter-spk');
            Route::get('/create-spk', [EdcController::class, 'createSpk'])->name('create-spk'); // Akses untuk manager_edc & staff_edc
            Route::post('/store-spk', [EdcController::class, 'storeSpk'])->name('store'); // Akses untuk manager_edc & staff_edc
            Route::post('/request-close/{id}', [EdcController::class, 'requestCloseSpk'])->name('request-close');
            Route::post('/spk/reject-to-rejected/{id}', [EdcController::class, 'rejectToRejected'])->name('reject-to-rejected');

        });

        // Rute tambahan untuk manager_edc
        Route::middleware('check.role:manager_edc')->group(function () {
            Route::get('/approval-reject', [EdcController::class, 'showApprovalRejectPage'])->name('approval-reject');
            Route::post('/reject-spk/{id}', [EdcController::class, 'rejectSPK'])->name('reject-spk');
        });

        // Rute API untuk semua role yang terautentikasi
        Route::middleware('auth')->prefix('api')->name('api.')->group(function () {
            Route::get('/spk-details/{id}', [EdcController::class, 'getSpkDetails'])->name('spk-details');
            Route::post('/spk/close/{id}', [EdcController::class, 'closeSpk'])->name('close');
            Route::post('/spk/update/{id}', [EdcController::class, 'update'])->name('edc.api.spk.update');
            Route::delete('/spk/delete/{id}', [EdcController::class, 'destroy'])->name('spk.delete');
            Route::put('/update_assign/{id}', [EdcController::class, 'update_assign']);


        });
    });



});
require __DIR__.'/auth.php';










// menu EDC
// Route::prefix('edc')->name('edc.')->group(function () {
//     Route::get('/', [EdcController::class, 'dashboard'])->name('dashboard'); 

//     Route::get('/assign-spk', [EdcController::class, 'assignSpk'])->name('assign-spk');
//     Route::post('/assign-spk/{id}', [EdcController::class, 'assignSpkAction'])->name('assign-spk-action');
//     Route::get('/api/spk-details/{id}', [EdcController::class, 'getSpkDetails']);
//     Route::post('/edc/assign-spk/{id}', [EdcController::class, 'assignSpkAction'])->name('edc.assign-spk-action');
    
//     Route::post('/reject-spk/{id}', [EdcController::class, 'rejectSPK'])->name('edc.reject-spk');


//     Route::get('/list-spk', [EdcController::class, 'listSpk'])->name('list-spk');
//     Route::post('/api/spk/request-close/{id}', [EdcController::class, 'requestCloseSpk'])->name('spk.request-close');

    

//     Route::get('/create-spk', [EdcController::class, 'createSpk'])->name('create-spk'); 
//     Route::post('/store-spk', [EdcController::class, 'storeSpk'])->name('store'); // Route POST untuk menyimpan SPK

//     Route::get('/approval-reject', [EdcController::class, 'showApprovalRejectPage'])->name('approval-reject');

//     //request to close 
//     Route::get('/assign-spk', [EdcController::class, 'showAssignSPK'])->name('assign-spk');
//     Route::post('/api/spk/close/{id}', [EdcController::class, 'closeSpk']);

//     Route::post('/api/spk/reject-to-rejected/{id}', [EdcController::class, 'rejectToRejected']);
// });