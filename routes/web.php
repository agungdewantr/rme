<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PrintController;
use App\Livewire\Appointment;
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

Route::get('/', Appointment::class)->name('appointment');
Route::middleware('guest')->group(function () {
    Route::get('/login', App\Livewire\Auth\Login::class)->name('login');
    Route::get('/forgot-password', App\Livewire\Auth\ForgotPasword::class)->name('forgot-password');
    Route::get('/register', App\Livewire\Auth\Register::class)->name('register');
});
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', App\Livewire\Dashboard::class)->name('dashboard');
    Route::get('/dashboard/queue', App\Livewire\Queue::class)->name('queue');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::prefix('/patient')->name('patient.')->namespace('App\Livewire\Patient')->group(function () {
        Route::get('/', 'Index')->name('index');
        Route::get('/create', 'Create')->name('create');
        Route::get('/{patient:uuid}', 'Show')->name('show');
        Route::get('/{patient:uuid}/edit', 'Edit')->name('edit');
    });
    Route::prefix('/drug-and-med-dev')->name('drug-and-med-dev.')->namespace('App\Livewire\DrugAndMedDev')->group(function () {
        Route::get('/', 'Index')->name('index');
        Route::get('/create', 'Create')->name('create');
        Route::get('/{drugMedDev:uuid}', 'Show')->name('show');
        Route::get('/{drugMedDev:uuid}/edit', 'Edit')->name('edit');
    });
    Route::prefix('/health-worker')->name('health-worker.')->namespace('App\Livewire\HealthWorker')->group(function () {
        Route::get('/', 'Index')->name('index');
    });
    Route::prefix('/promo-event')->name('promo-event.')->namespace('App\Livewire\Promo')->group(function () {
        Route::get('/', 'Index')->name('index');
    });
    Route::prefix('/action')->name('action.')->namespace('App\Livewire\Action')->group(function () {
        Route::get('/', 'Index')->name('index');
    });
    Route::prefix('/medical-record')->name('medical-record.')->namespace('App\Livewire\MedicalRecord')->group(function () {
        Route::get('/', 'Index')->name('index');
        Route::get('/create/{registration:uuid?}', 'Create')->name('create');
        Route::get('/{uuid}/show', 'Show')->name('show');
        Route::get('/{uuid}/edit', 'Edit')->name('edit');
    });
    Route::prefix('/first-entry')->name('first-entry.')->namespace('App\Livewire\FirstEntry')->group(function () {
        Route::get('/', 'Index')->name('index');
        Route::get('/create/{registration:uuid?}', 'Create')->name('create');
        Route::get('/{uuid}/show', 'Show')->name('show');
        Route::get('/{uuid}/edit', 'Edit')->name('edit');
    });
    Route::prefix('/outcome')->name('outcome.')->namespace('App\Livewire\Outcome')->group(function () {
        Route::get('/', 'Index')->name('index');
        Route::get('/create', 'Create')->name('create');
        Route::get('/{uuid}/show', 'Show')->name('show');
        Route::get('/{uuid}/edit', 'Edit')->name('edit');
    });
    Route::prefix('/registration')->name('registration.')->namespace('App\Livewire\Registration')->group(function () {
        Route::get('/', 'Index')->name('index');
    });
    Route::prefix('/payment')->name('payment.')->namespace('App\Livewire\Payment')->group(function () {
        Route::get('/', 'Index')->name('index');
        Route::get('/create/{medical_record_uuid?}', 'Create')->name('create');
        Route::get('/{transaction:uuid}/show', 'Show')->name('show');
        Route::get('/{transaction:uuid}/edit', 'Edit')->name('edit');
    });
    Route::get('/payment/{transaction:uuid}/invoice', [InvoiceController::class, 'index'])->name('payment.invoice');
    Route::get('/first-entry/{firstEntry:uuid}/print', [PrintController::class, 'print_firstEntry'])->name('first-entry.print');
    Route::get('/patient/{patient:uuid}/print', [PrintController::class, 'print_patient'])->name('patient.print');
    Route::prefix('/role')->name('role.')->namespace('App\Livewire\Role')->group(function () {
        Route::get('/', 'Index')->name('index');
        Route::get('/{role:uuid}/show', 'Show')->name('show');
        Route::get('/{role:uuid}/edit', 'Edit')->name('edit');
    });
    Route::prefix('/report')->namespace('App\Livewire\Report')->group(function () {
        Route::get('/', 'Index')->name('report.index');
        Route::get('/clinic', 'Index')->name('report.clinic');
        Route::get('/income-per-patient', 'IncomePatient')->name('report.income-per-patient');
        Route::get('/stock-ledger', 'StockLedger')->name('stock.ledger');
        Route::get('/stock-balance', 'StockBalance')->name('stock.balance');
    });
    Route::get('report/print', [PrintController::class, 'print_report'])->name('report.print');
    Route::prefix('/laborate')->name('laborate.')->namespace('App\Livewire\Laborate')->group(function () {
        Route::get('/', 'Index')->name('index');
    });
    Route::prefix('/stock-entry')->name('stock-entry.')->namespace('App\Livewire\StockEntry')->group(function () {
        Route::get('/', 'Index')->name('index');
        Route::get('/create', 'Create')->name('create');
        Route::get('/{stockEntry:uuid}', 'Show')->name('show');
    });
    Route::prefix('/stock-transfer')->name('stock-transfer.')->namespace('App\Livewire\StockTransfer')->group(function () {
        Route::get('/', 'Index')->name('index');
        Route::get('/create', 'Create')->name('create');
        Route::get('/{uuid}', 'Show')->name('show');
    });
    Route::prefix('/poli')->name('poli.')->namespace('App\Livewire\Poli')->group(function () {
        Route::get('/', 'Index')->name('index');
    });
    Route::prefix('/category-outcome')->name('category-outcome.')->namespace('App\Livewire\CategoryOutcome')->group(function () {
        Route::get('/', 'Index')->name('index');
    });
    Route::prefix('/branch')->name('branch.')->namespace('App\Livewire\Branch')->group(function () {
        Route::get('/', 'Index')->name('index');
        Route::get('/create', 'Create')->name('create');
        Route::get('/{uuid}/show', 'Show')->name('show');
        Route::get('/{uuid}/edit', 'Edit')->name('edit');
        Route::get('/{uuid}/delete', 'Delete')->name('delete');
    });
    Route::get('/doctor-fee', App\Livewire\Setting\Fee\Index::class)->name('doctor-fee.index');
    Route::get('/setting', App\Livewire\Setting\Index::class)->name('setting.index');
});
