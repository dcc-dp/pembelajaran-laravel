<?php

use App\Exports\UserExport;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ChatingController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OngkirController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/check-cloud', function () {
    return config('services.cloudinary.url');
});

// routes/web.php
Route::get('/upload', [ImageController::class, 'index'])->name('upload.form');
Route::post('/upload', [ImageController::class, 'store'])->name('upload.image');
Route::delete('/image/{image}', [ImageController::class, 'destroy'])->name('image.delete');

// routes/web.php
Route::get('/person', [CertificateController::class, 'index'])->name('certificate.index');
Route::post('/person', [CertificateController::class, 'store'])->name('person.store');
Route::get('/person/{person}/edit', [CertificateController::class, 'edit'])->name('person.edit');
Route::put('/person/{person}', [CertificateController::class, 'update'])->name('person.update');
Route::delete('/certificate/{certificate}', [CertificateController::class, 'destroy'])->name('certificate.destroy');
Route::get('/certificate/{public_id}/view', [CertificateController::class, 'viewCertificate'])->name('certificate.view');

Route::get('cek-ongkir', [OngkirController::class, 'index']);
Route::get('get-kota/{id}', [OngkirController::class, 'getKota']);
Route::get('get-kec/{id}', [OngkirController::class, 'getKec']);
Route::post('cek-rong', [OngkirController::class, 'cekRong']);

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth','verified'])->get('/dashboard',[DashboardController::class,
    'index'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/message', [ChatController::class, 'index'])->name('messages');
    Route::post('/send-message', [ChatController::class, 'sendMessage']);
    Route::get('/get-messages', [ChatController::class, 'getMessages']);

    Route::get('/chating',[ChatingController::class, 'index'])->name('chating');
    Route::post('/upload-chat-image', [ChatingController::class, 'store'])->name('chat.upload');
    Route::delete('/chat/delete-image', [ChatingController::class, 'deleteImage'])->name('chat.deleteImage');

});



require __DIR__.'/auth.php';

Route::resource('/blogs', App\Http\Controllers\BlogController::class);
Route::resource('/articles', App\Http\Controllers\ArticleController::class);

use Illuminate\Support\Facades\Artisan;
use Maatwebsite\Excel\Facades\Excel;

Route::get('/artisan/storage-link', function () {
    abort_unless(app()->environment('local'), 403);
    Artisan::call('storage:link');
    return 'Storage link berhasil dibuat';
});

Route::get('/export/excel', function () {
     return Excel::store(new UserExport,public_path('jara.xlsx'));
});
