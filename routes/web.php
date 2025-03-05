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
use App\Http\Controllers\MesBatchManagementController;


use App\Http\Controllers\GrafanaController;




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

    Route::prefix('mes/monitoring')->name('monitoring.')->group(function () {
        Route::get('/powder-plant', [GrafanaController::class, 'powderPlant'])->name('powder-plant');

    });

    Route::get('/finance-dashboard', function () {
        return redirect('http://budget.lautan-luas.com:8301/');
    })->name('finance.dashboard');    

    // Menu Procurement
    Route::prefix('procurement')->name('procurement.')->middleware('auth')->group(function () {
        Route::middleware('check.role:spv_procurement,manager_procurement')->group(function () {
            Route::get('/dashboard', fn() => redirect('http://madam.lautan-luas.com/'))->name('dashboard');
            Route::get('/kpi', fn() => redirect('http://147.93.104.113:8030/'))->name('kpi');
        });
    });


    Route::get('/exim', function () {
        return redirect('http://impac.lautan-luas.com/');
    })->name('exim');

    Route::get('/reports', function () {
        return redirect('http://hsemreport.lautan-luas.com/');
    })->name('reports');

    Route::get('/monitoring', function () {
        return redirect('http://delivery.lautan-luas.com:8201/');
    })->name('monitoring');

    // Grouping untuk Sales Marketing CSR
    Route::prefix('salesmarketing/csr')->name('csr.')->middleware('check.role:manager_csr,spv_csr,staff_csr,staff_edc,manager_edc')->group(function () {
        // Halaman Opportunity
        Route::get('/opportunity', [SalesMarketingController::class, 'opportunity'])->name('opportunity');
        Route::post('/request-to-ppic', [SalesMarketingController::class, 'storePpicRequest']);
        Route::post('/save-to-draft', [SalesMarketingController::class, 'saveToDraft']);
        // end
        
        // Halaman Status Opportunity
        Route::get('/status-request-ppic', [SalesMarketingController::class, 'statusRequestPpic'])->name('status-request-ppic');
        Route::get('/api/status-request-data', [SalesMarketingController::class, 'getStatusRequestData']);
        Route::post('/ppic-eticket/update-status', [SalesMarketingController::class, 'updateStatus'])->name('ppic.update-status');
        Route::post('/opportunity/{id}/update-products', [SalesMarketingController::class, 'updateProducts']);
        Route::delete('/opportunity/{id}', [SalesMarketingController::class, 'deleteOpportunity']);
        // Edit dan Delete Opportunity (dari Status Request PPIC)
        Route::put('/api/status-request-ppic/{id}', [SalesMarketingController::class, 'updateProducts']);
        Route::delete('/api/status-request-ppic/{id}', [SalesMarketingController::class, 'deleteOpportunity']);
        Route::get('/api/status-request-ppic/{id}', [SalesMarketingController::class, 'getOpportunityById']);
        // end

        // Halaman So-Number
        Route::get('/so-number', [SalesMarketingController::class, 'showSoNumberPage'])->name('so-number');
        Route::post('/request-to-delivery', [SalesMarketingController::class, 'requestToDelivery'])->name('request-to-delivery');


        // Halaman Status Delivery
        Route::get('/status-delivery', [SalesMarketingController::class, 'showDeliveryStatus'])->name('status-delivery');
        Route::delete('/delivery/delete/{id}', [SalesMarketingController::class, 'deleteDelivery'])->name('delivery.delete');
        Route::post('/delivery/upload-file/{id}', [SalesMarketingController::class, 'uploadFile'])->name('delivery.upload-file');

    });

    // Menu card PPIC
    Route::prefix('ppic-eticket')->name('ppic.')->group(function () {
        Route::get('/', [PpicController::class, 'index'])->name('eticket'); // Halaman utama
        // List data of SPK
        Route::get('/ppic/requests', [PpicController::class, 'showPpicData'])->name('requests'); // API data SPK
        Route::post('/update-status-preparing', [PpicController::class, 'updateStatusToPreparing'])->name('update-status-preparing');
        Route::post('/ppic/revision-date', [PpicController::class, 'updateRevisionDate'])->name('revision-date');
        Route::post('/ppic/not-accept', [PpicController::class, 'notAcceptReason'])->name('not-accept');

        // Create SPK to Production
        Route::get('/create-spk', [PpicController::class, 'createSpkIndex'])->name('create-spk');
        Route::post('/store', [PpicController::class, 'store'])->name('store-spk');

        // Masterdata 
        Route::get('/master-data', [PpicController::class, 'masterData'])->name('master-data');
        
        // card monitoring
        Route::get('/monitoring-spk', [PpicController::class, 'monitoringSpk'])->name('monitoring-spk');

    });

    // Menu card Delivery
    Route::prefix('delivery-spk')->group(function () {
        Route::get('/', [DeliveryController::class, 'index'])->name('delivery.spk'); // Halaman utama SPK Delivery
        Route::get('/requests', [DeliveryController::class, 'getAllDeliveries'])->name('delivery.requests'); // API data Delivery
        Route::post('/update-status-delivery', [DeliveryController::class, 'updateStatusToDelivery'])->name('delivery.update-status-delivery');
        Route::post('/close-delivery', [DeliveryController::class, 'closeDelivery'])->name('delivery.close');
        Route::post('/{id}/update-products', [DeliveryController::class, 'updateProducts']); // Update produk tertentu
        Route::delete('/{id}', [DeliveryController::class, 'deleteDelivery']); // Hapus data Delivery
        // Tambahkan rute untuk aksi revision
        Route::post('/revision/{id}', [DeliveryController::class, 'updateRevision'])->name('delivery.revision');

        // Tambahkan rute untuk aksi Deliver
        Route::post('/deliver', [DeliveryController::class, 'deliver'])->name('delivery.deliver');
        // rute aksi customer accept
        Route::post('/customer-accept/{id}', [DeliveryController::class, 'customerAccept'])->name('delivery.customer-accept');
        // rute aksi reject
        Route::post('/reject/{poNumber}', [DeliveryController::class, 'rejectDelivery'])->name('delivery.reject');
        // rute arriving
        Route::post('/upload-attachment/{poNumber}', [DeliveryController::class, 'uploadAttachment'])->name('delivery.upload-attachment');


    });

    

    // Menu MES
    Route::prefix('mes')->name('mes-menu.')->group(function () {
        Route::prefix('batchmanagement')->name('batchmanagement.')->group(function () {
            Route::get('/planning-work-date', [MesBatchManagementController::class, 'planningWorkDate'])
                ->name('planning');
            
            Route::get('/planning-work-date/data', [MesBatchManagementController::class, 'getPlanningWorkDates'])
                ->name('planning.data');
            
            Route::post('/planning-work-date/store', [MesBatchManagementController::class, 'store'])
                ->name('planning.store');
            
            Route::get('/planning-work-date/{id}/edit', [MesBatchManagementController::class, 'edit'])
                ->name('planning.edit');
            
            // Pastikan rute update ini terdefinisi dengan benar
            Route::put('/planning-work-date/{id}', [MesBatchManagementController::class, 'update'])
                ->name('planning.update');
        });
    });

    // Menu CMMS
    Route::prefix('cmms')->name('cmms-menu.')->group(function () {

        Route::get('/dashboard/powder', [GrafanaController::class, 'cmmsPowderPlant'])->name('dashboard.powder');
    });


    // Menu EDC
    Route::prefix('edc')->name('edc.')->group(function () {
            Route::get('/list-spk', [EdcController::class, 'listSpk'])->name('list-spk'); // Akses untuk manager_edc & staff_edc
            Route::get('/filter-spk', [EdcController::class, 'filterSpk'])->name('filter-spk');
            Route::get('/create-spk', [EdcController::class, 'createSpk'])->name('create-spk'); // Akses untuk manager_edc & staff_edc
            Route::post('/store-spk', [EdcController::class, 'storeSpk'])->name('store'); // Akses untuk manager_edc & staff_edc

        // Rute untuk manager_edc dan staff_edc
        Route::middleware('check.role:manager_edc,staff_edc')->group(function () {
            Route::get('/', [EdcController::class, 'dashboard'])->name('dashboard');
            Route::get('/assign-spk', [EdcController::class, 'assignSpk'])->name('assign-spk');
            Route::post('/assign-spk/{id}', [EdcController::class, 'assignSpkAction'])->name('assign-spk-action');
            
            Route::post('/request-close/{id}', [EdcController::class, 'requestCloseSpk'])->name('request-close');
            Route::post('/spk/reject-to-rejected/{id}', [EdcController::class, 'rejectToRejected'])->name('reject-to-rejected');
            Route::get('/unassigned-spk', [EdcController::class, 'getUnassignedSpkData'])->name('unassigned-spk');
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