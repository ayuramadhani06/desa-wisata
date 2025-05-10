<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AdminController, BendaharaController, PenginapanController,
    BeritaController, LoginController, LoginnController,
    RegisterController, WisataController, ContactController,
    OwnerController, HomeController
};

// Halaman publik
Route::resource('/', HomeController::class);
Route::get('/penginapan', [PenginapanController::class, 'tampilPenginapan']);
Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');
Route::resource('/wisata', WisataController::class);
Route::resource('/contact', ContactController::class);

// Registrasi Pelanggan
Route::middleware('guest')->group(function() {
    Route::get('/register', [RegisterController::class, 'showForm']);
    Route::post('/register', [RegisterController::class, 'store'])->name('register');

    Route::get('/loginn', [LoginnController::class, 'index'])->name('loginn');
    Route::post('/loginn', [LoginnController::class, 'store'])->name('loginn.store');

    Route::resource('/login', LoginController::class);
    Route::post('/login', [LoginController::class, 'login'])->name('login');
});

// Logout pelanggan
Route::post('/logoutP', [RegisterController::class, 'logout'])->name('logoutP');

// Logout admin
Route::post('/logout', [LoginController::class, 'logout']);

// Setelah login
Route::middleware(['auth'])->group(function(){
    //ADMIN
    Route::resource('/admin', AdminController::class)->middleware('userAkses:admin');

    //user management
    Route::get('/userm', [AdminController::class, 'con1'])->middleware('userAkses:admin');
    Route::post('/userm/store', [AdminController::class, 'store'])->name('admin.userm.store')->middleware('userAkses:admin');
    Route::put('/userm/{id}', [AdminController::class, 'update'])->name('admin.userm.update')->middleware('userAkses:admin');
    Route::put('/userm/banned/{id}', [AdminController::class, 'banned'])->name('admin.userm.banned')->middleware('userAkses:admin');
    
    //berita managemenet
    Route::get('/news', [AdminController::class, 'con2'])->name('admin.news')->middleware('userAkses:admin');
    Route::post('/news/store', [AdminController::class, 'newsStore'])->name('admin.news.store')->middleware('userAkses:admin');
    Route::post('/news/delete', [AdminController::class, 'newsDelete'])->name('admin.news.delete')->middleware('userAkses:admin');
    Route::get('/news/{id}/edit', [AdminController::class, 'con2'])->name('admin.news.edit')->middleware('userAkses:admin');
    Route::put('/news/{id}/update', [AdminController::class, 'newsUpdate'])->name('admin.news.update')->middleware('userAkses:admin');
    //kategori
    Route::post('/kategori/store', [AdminController::class, 'kategoriStore'])->name('admin.kategori.store')->middleware('userAkses:admin');
    Route::post('/kategori/update', [AdminController::class, 'kategoriUpdate'])->name('admin.kategori.update')->middleware('userAkses:admin');
    Route::post('/kategori/delete', [AdminController::class, 'kategoriDelete'])->name('admin.kategori.delete')->middleware('userAkses:admin');
    

    //OWNER
    Route::resource('/owner', OwnerController::class)->middleware('userAkses:pemilik');

    //BENDAHARA
    Route::resource('/bendahara', BendaharaController::class)->middleware('userAkses:bendahara');

    //homestay
    Route::get('/homestay', [BendaharaController::class, 'cont1'])->middleware('userAkses:bendahara');
    Route::post('/homestay/store', [BendaharaController::class, 'store'])->name('homestay.store')->middleware('userAkses:bendahara');
    Route::get  ('/homestay/{id}/edit', [BendaharaController::class, 'edit'])->name('homestay.edit')->middleware('userAkses:bendahara');
    Route::put  ('/homestay/{id}', [BendaharaController::class, 'update'])->name('homestay.update')->middleware('userAkses:bendahara');
    Route::delete('/homestay/delete/{id}', [BendaharaController::class, 'destroy'])->name('homestay.destroy')->middleware('userAkses:bendahara');
    
    Route::get('/konfir', [BendaharaController::class, 'cont2'])->middleware('userAkses:bendahara');

    //OBJEK WISATAA
    Route::get('/obwi', [BendaharaController::class, 'cont3'])->name('bendahara.obwi')->middleware('userAkses:bendahara');
    // objek Wisata
    Route::get('/obwi/{id}/edit', [BendaharaController::class, 'cont3'])->name('bendahara.obwi.edit')->middleware('userAkses:bendahara');
    
    // Objek Wisata
    Route::post('/obwi/store', [BendaharaController::class, 'storeObyekWisata'])->name('bendahara.obwi.store')->middleware('userAkses:bendahara');
    Route::put('/obwi/{id}/update', [BendaharaController::class, 'updateObyekWisata'])->name('bendahara.obwi.update')->middleware('userAkses:bendahara');
    Route::post('/obwi/delete', [BendaharaController::class, 'destroyObyekWisata'])->name('bendahara.obwi.delete')->middleware('userAkses:bendahara');
    
    // Kategori Wisata
    Route::post('/kategori-wisata/store', [BendaharaController::class, 'storeKategoriWisata'])->name('bendahara.kategori.store')->middleware('userAkses:bendahara');
    Route::post('/kategori-wisata/update', [BendaharaController::class, 'updateKategoriWisata'])->name('bendahara.kategori.update')->middleware('userAkses:bendahara');
    Route::post('/kategori-wisata/delete', [BendaharaController::class, 'destroyKategoriWisata'])->name('bendahara.kategori.delete')->middleware('userAkses:bendahara');

    Route::get('/pakwis', [BendaharaController::class, 'cont4'])->middleware('userAkses:bendahara');
});

// Redirect ke logout jika buka /home secara langsung
Route::get('/home', fn () => redirect('/logout'));







//INI SEBELUMNYA

// <?php

// use App\Http\Controllers\AdminController;
// use App\Http\Controllers\BendaharaController;
// use Illuminate\Support\Facades\Route;
// // use Illuminate\Support\Facades\Auth;
// use App\Http\Controllers\PenginapanController;
// // use App\Http\Controllers\ReservasiController;
// use App\Http\Controllers\BeritaController;
// use App\Http\Controllers\LoginController;
// use App\Http\Controllers\LoginnController;
// use App\Http\Controllers\RegisterController;
// use App\Http\Middleware\userAkses;




// // Route::get('/', function () {
// //     return view('welcome');
// // });

// Route::resource('/', App\Http\Controllers\HomeController::class);
// Route::resource('/penginapan', App\Http\Controllers\PenginapanController::class);
// Route::resource('/berita', App\Http\Controllers\BeritaController::class);
// Route::resource('/register', App\Http\Controllers\RegisterController::class);
// Route::resource('/wisata', App\Http\Controllers\WisataController::class);
// Route::resource('/contact', App\Http\Controllers\ContactController::class);
// Route::get('/loginn', [LoginnController::class, 'index'])->name('loginn');
// Route::post('/loginn', [LoginnController::class, 'store'])->name('loginn.store');

// Route::middleware(['guest'])->group(function(){
//     Route::resource('/login', App\Http\Controllers\LoginController::class);
//     Route::post('/login', [LoginController::class, 'login'])->name('login');
// });

// Route::middleware(['auth'])->group(function(){
//     Route::resource('/admin', App\Http\Controllers\AdminController::class)->middleware('userAkses:admin');
//     Route::get('/userm', [AdminController::class, 'con1'])->middleware('userAkses:admin');
//     Route::get('/news', [AdminController::class, 'con2'])->middleware('userAkses:admin');
//     Route::resource('/owner', App\Http\Controllers\OwnerController::class)->middleware('userAkses:pemilik');
//     Route::resource('/bendahara', App\Http\Controllers\BendaharaController::class)->middleware('userAkses:bendahara');
//     Route::get('/homestay', [BendaharaController::class, 'cont1'])->middleware('userAkses:bendahara');
//     Route::get('/konfir', [BendaharaController::class, 'cont2'])->middleware('userAkses:bendahara');
//     Route::get('/obwi', [BendaharaController::class, 'cont3'])->middleware('userAkses:bendahara');
//     Route::get('/pakwis', [BendaharaController::class, 'cont4'])->middleware('userAkses:bendahara');
//     Route::post('/logout', [LoginController::class, 'logout']);
// });


// Route::get('/register', [RegisterController::class, 'showForm']);
// Route::post('/register', [RegisterController::class, 'store'])->name('register');

// //yang ini ya yg kata login/register
// Route::post('/logoutP', [RegisterController::class, 'logout'])->name('logoutP');

// Route::get('/home', function(){
//     return redirect('/logout');
// });










//ini gak kepake ya, cm emg blm di apus aj

// Route::resource('/homestay', App\Http\Controllers\HomeStayController::class);
// Route::resource('/konfir', App\Http\Controllers\HomeStayController::class);
// Route::resource('/obwi', App\Http\Controllers\ObwiController::class);
// Route::resource('/pakwis', App\Http\Controllers\PakwisController::class);

// Route::resource('users', PenggunaController::class);
// Route::post('users/{user}/ban', [PenggunaController::class, 'ban'])->name('users.ban');




// Route::controller(RegisterController::class)->group(function () {
//     Route::get('register', 'register')->name('register');
//     Route::post('register', 'registerSave')->name('register.save');
// });
     












// Route::resource('/homestay', App\Http\Controllers\HomeStayController::class);
// Route::resource('/konfir', App\Http\Controllers\HomeStayController::class);
// Route::resource('/obwi', App\Http\Controllers\ObwiController::class);
// Route::resource('/pakwis', App\Http\Controllers\PakwisController::class);

// Route::resource('users', PenggunaController::class);
// Route::post('users/{user}/ban', [PenggunaController::class, 'ban'])->name('users.ban');




// Route::controller(RegisterController::class)->group(function () {
//     Route::get('register', 'register')->name('register');
//     Route::post('register', 'registerSave')->name('register.save');
// });
     