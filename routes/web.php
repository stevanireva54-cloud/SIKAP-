<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;

use App\Http\Controllers\BeritaAcaraController;

use App\Http\Controllers\DocumentController;

use App\Http\Controllers\DashboardController;

use App\Http\Controllers\EmployeeController;

use App\Http\Controllers\MocController;

use App\Http\Controllers\ScheduleController;

use App\Http\Controllers\SignatureController;

use App\Http\Controllers\SuratTugasController;

/*

|--------------------------------------------------------------------------

| GUEST ROUTES

|--------------------------------------------------------------------------

*/

Route::middleware('guest')->group(function () {

    /*

    |--------------------------------------------------------------------------

    | LOGIN

    |--------------------------------------------------------------------------

    */

    Route::get(

        '/login',

        [LoginController::class, 'showLogin']

    )->name('login');

    Route::post(

        '/login',

        [LoginController::class, 'login']

    )->name('login.process');

});

/*

|--------------------------------------------------------------------------

| AUTHENTICATED ROUTES

|--------------------------------------------------------------------------

*/

Route::middleware('auth')->group(function () {

    // Pengaturan revisi Formulir MOC dan Surat Tugas.
    Route::get(
        '/pengaturan/revisi-dokumen',
        [\App\Http\Controllers\DocumentRevisionController::class, 'index']
    )->name('document-revisions.index');

    Route::put(
        '/pengaturan/revisi-dokumen',
        [\App\Http\Controllers\DocumentRevisionController::class, 'update']
    )->name('document-revisions.update');

    /*

    |--------------------------------------------------------------------------

    | HOME

    |--------------------------------------------------------------------------

    */

    Route::get(

        '/',

        function () {

            return redirect()->route('dashboard');

        }

    )->name('home');

    /*

    |--------------------------------------------------------------------------

    | DASHBOARD

    |--------------------------------------------------------------------------

    */

    Route::get(

        '/dashboard',

        [DashboardController::class, 'index']

    )->name('dashboard');

    /*

    |--------------------------------------------------------------------------

    | LOGOUT

    |--------------------------------------------------------------------------

    */

    Route::post(

        '/logout',

        [LoginController::class, 'logout']

    )->name('logout');

    /*

    |--------------------------------------------------------------------------

    | FORMULIR MOC

    |--------------------------------------------------------------------------

    */

    Route::get(

        '/moc/create',

        [MocController::class, 'create']

    )->name('moc.create');

    Route::post(

        '/moc/generate',

        [MocController::class, 'generate']

    )->name('moc.generate');

    Route::post(

        '/moc/generate-pdf',

        [MocController::class, 'generatePdf']

    )->name('moc.generate-pdf');

    Route::get(

        '/moc/debug-template',

        [MocController::class, 'debugTemplate']

    )->name('moc.debug-template');

    /*

    |--------------------------------------------------------------------------

    | BERITA ACARA

    |--------------------------------------------------------------------------

    */

    Route::get(

        '/berita-acara/create',

        [BeritaAcaraController::class, 'create']

    )->name('berita-acara.create');

    Route::post(

        '/berita-acara/generate',

        [BeritaAcaraController::class, 'generate']

    )->name('berita-acara.generate');

    Route::post(

        '/berita-acara/generate-pdf',

        [BeritaAcaraController::class, 'generatePdf']

    )->name('berita-acara.generate-pdf');

    Route::get(

        '/berita-acara/debug-template',

        [BeritaAcaraController::class, 'debugTemplate']

    )->name('berita-acara.debug-template');

    /*

    |--------------------------------------------------------------------------

    | SURAT TUGAS

    |--------------------------------------------------------------------------

    */

    Route::get(

        '/surat-tugas/create',

        [SuratTugasController::class, 'create']

    )->name('surat-tugas.create');

    Route::post(

        '/surat-tugas/generate',

        [SuratTugasController::class, 'generate']

    )->name('surat-tugas.generate');

    Route::post(

        '/surat-tugas/generate-pdf',

        [SuratTugasController::class, 'generatePdf']

    )->name('surat-tugas.generate-pdf');

    Route::get(

        '/surat-tugas/debug-template',

        [SuratTugasController::class, 'debugTemplate']

    )->name('surat-tugas.debug-template');

    /*

    |--------------------------------------------------------------------------

    | DATA KARYAWAN

    |--------------------------------------------------------------------------

    */

    Route::get('/karyawan/export', [EmployeeController::class, 'export'])

        ->name('employees.export');

    Route::get(

        '/karyawan',

        [EmployeeController::class, 'index']

    )->name('employees.index');

    Route::post(

        '/karyawan',

        [EmployeeController::class, 'store']

    )->name('employees.store');

    Route::put(

        '/karyawan/{employee}',

        [EmployeeController::class, 'update']

    )->name('employees.update');

    Route::delete(

        '/karyawan/{employee}',

        [EmployeeController::class, 'destroy']

    )->name('employees.destroy');

    /*

    |--------------------------------------------------------------------------

    | FOTO KARYAWAN

    |--------------------------------------------------------------------------

    */

    Route::get(

        '/karyawan/{employee}/foto',

        [EmployeeController::class, 'photo']

    )->name('employees.photo');

    /*

    |--------------------------------------------------------------------------

    | DOKUMEN KARYAWAN

    |--------------------------------------------------------------------------

    */

    Route::get(

        '/karyawan/dokumen/{document}/lihat',

        [EmployeeController::class, 'viewDocument']

    )->name('employees.documents.view');

    Route::get(

        '/karyawan/dokumen/{document}/download',

        [EmployeeController::class, 'downloadDocument']

    )->name('employees.documents.download');

    Route::put(

        '/karyawan/dokumen/{document}',

        [EmployeeController::class, 'updateDocument']

    )->name('employees.documents.update');

    Route::delete(

        '/karyawan/dokumen/{document}',

        [EmployeeController::class, 'destroyDocument']

    )->name('employees.documents.destroy');

    /*

    |--------------------------------------------------------------------------

    | SCHEDULE KARYAWAN

    |--------------------------------------------------------------------------

    |

    | S   = Siang

    | M   = Malam

    | ON  = Standby lapangan 24 jam

    | OFF = Libur / Off

    |

    */

    /*

    |--------------------------------------------------------------------------

    | HALAMAN SCHEDULE

    |--------------------------------------------------------------------------

    */

    Route::get('/schedule/export', [ScheduleController::class, 'export'])->name('schedules.export');

    Route::get(

        '/schedule',

        [ScheduleController::class, 'index']

    )->name('schedules.index');

    /*

    |--------------------------------------------------------------------------

    | TAMBAH KARYAWAN KE SCHEDULE

    |--------------------------------------------------------------------------

    */

    Route::post(

        '/schedule/assignment',

        [ScheduleController::class, 'storeAssignment']

    )->name('schedules.assignments.store');

    /*

    |--------------------------------------------------------------------------

    | UPDATE RIG / CREW

    |--------------------------------------------------------------------------

    */

    Route::put(

        '/schedule/assignment/{assignment}',

        [ScheduleController::class, 'updateAssignment']

    )->name('schedules.assignments.update');

    /*

    |--------------------------------------------------------------------------

    | HAPUS KARYAWAN DARI SCHEDULE

    |--------------------------------------------------------------------------

    */

    Route::delete(

        '/schedule/assignment/{assignment}',

        [ScheduleController::class, 'destroyAssignment']

    )->name('schedules.assignments.destroy');

    /*

    |--------------------------------------------------------------------------

    | SIMPAN SCHEDULE SATU HARI

    |--------------------------------------------------------------------------

    */

    Route::post(

        '/schedule/assignment/{assignment}/day',

        [ScheduleController::class, 'saveDay']

    )->name('schedules.day.save');

    /*

    |--------------------------------------------------------------------------

    | KOSONGKAN SCHEDULE SATU HARI

    |--------------------------------------------------------------------------

    */

    Route::delete(

        '/schedule/assignment/{assignment}/day',

        [ScheduleController::class, 'clearDay']

    )->name('schedules.day.clear');

    /*

    |--------------------------------------------------------------------------

    | BULK SCHEDULE SATU KARYAWAN

    |--------------------------------------------------------------------------

    */

    Route::post(

        '/schedule/assignment/{assignment}/bulk',

        [ScheduleController::class, 'bulkSave']

    )->name('schedules.bulk.save');

    /*

    |--------------------------------------------------------------------------

    | BULK SCHEDULE SATU CREW

    |--------------------------------------------------------------------------

    */

    Route::post(

        '/schedule/crew/bulk',

        [ScheduleController::class, 'bulkCrew']

    )->name('schedules.crew\\\\.bulk');

    /*

    |--------------------------------------------------------------------------

    | LANJUTKAN SEMUA SCHEDULE KE TAHUN BERIKUTNYA

    |--------------------------------------------------------------------------

    */

    Route::post(

        '/schedule/continue-year',

        [ScheduleController::class, 'continueYear']

    )->name('schedules.continue-year');

    /*

    |--------------------------------------------------------------------------

    | RIWAYAT SEMUA DOKUMEN

    |--------------------------------------------------------------------------

    */

    Route::get('/documents/export', [DocumentController::class, 'export'])->name('documents.export');

    Route::get(

        '/documents',

        [DocumentController::class, 'index']

    )->name('documents.index');

    /*

    |--------------------------------------------------------------------------

    | RIWAYAT BERITA ACARA

    |--------------------------------------------------------------------------

    */

    Route::get(

        '/documents/berita-acara',

        [DocumentController::class, 'beritaAcara']

    )->name('documents.berita-acara');

    /*

    |--------------------------------------------------------------------------

    | RIWAYAT MOC

    |--------------------------------------------------------------------------

    */

    Route::get(

        '/documents/moc',

        [DocumentController::class, 'moc']

    )->name('documents.moc');

    /*

    |--------------------------------------------------------------------------

    | RIWAYAT SURAT TUGAS

    |--------------------------------------------------------------------------

    */

    Route::get(

        '/documents/surat-tugas',

        [DocumentController::class, 'suratTugas']

    )->name('documents.surat-tugas');

    /*

    |--------------------------------------------------------------------------

    | DOWNLOAD DOKUMEN

    |--------------------------------------------------------------------------

    |

    | Dipakai oleh:

    | - Berita Acara

    | - Formulir MOC

    | - Surat Tugas

    | - Semua Dokumen

    |

    */

    Route::get(

        '/documents/{document}/download',

        [DocumentController::class, 'download']

    )->name('documents.download');

    /*

    |--------------------------------------------------------------------------

    | HAPUS DOKUMEN

    |--------------------------------------------------------------------------

    |

    | Dipakai oleh:

    | - Berita Acara

    | - Formulir MOC

    | - Surat Tugas

    | - Semua Dokumen

    |

    */

    Route::delete(

        '/documents/{document}',

        [DocumentController::class, 'destroy']

    )->name('documents.destroy');

    /*

    |--------------------------------------------------------------------------

    | SIGNATURE LIBRARY

    |--------------------------------------------------------------------------

    */

    Route::get(

        '/signatures',

        [SignatureController::class, 'index']

    )->name('signatures.index');

    Route::post(

        '/signatures',

        [SignatureController::class, 'store']

    )->name('signatures.store');

    Route::get(

        '/signatures/{signature}/image',

        [SignatureController::class, 'image']

    )->name('signatures.image');

    Route::delete(

        '/signatures/{signature}',

        [SignatureController::class, 'destroy']

    )->name('signatures.destroy');

});
