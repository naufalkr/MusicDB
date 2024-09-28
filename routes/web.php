<?php

use App\Http\Controllers\SongController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\SingerController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\RecordlabelController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ShowController;
use App\Http\Controllers\EpisodeController;
use App\Models\Genre;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
// use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/api/docs', function () {
    return redirect('/api/documentation');
})->name('api-page');



// Route::get('/', function () {
//     return view('layout.base');
// })->name('home');  // Named route untuk halaman utama

// Route::prefix('/pertemuan1')->group(function(){
//     Route::get('/basic', function () {
//         return view('pertemuan1.basic');
//     });
//     Route::get('/named', fn() => view('pertemuan1.named'))->name('named');
//     Route::get('/param', fn() => view('pertemuan1.param'))->name('param');
//     Route::get('/param/{param1}', [Pertemuan1Controller::class, 'param1'])->name('param1');
//     Route::get('/param/{param1}/{param2}', [Pertemuan1Controller::class, 'param2'])->name('param2');
    
//     Route::match(['get', 'post'], '/genap-ganjil', [Pertemuan1Controller::class, 'genapGanjil'])->name('genap-ganjil');
//     Route::get('/fibbonaci',[Pertemuan1Controller::class,'fibonacci'])->name('fibonacci');
//     Route::get('/prima', [Pertemuan1Controller::class, 'bilanganPrima'])->name('bilangan-prima');
    
    
//     Route::prefix('/group1')->group(function(){
//         Route::get('/page1', fn() => view('pertemuan1.group1page1'))->name('group1page1');
//         Route::get('/page2', fn() => view('pertemuan1.group1page2'))->name('group1page2');
//     });
//     Route::prefix('/group2')->group(function(){
//         Route::get('/page1', fn() => view('pertemuan1.group2page1'))->name('group2page1');
//         Route::get('/page2', fn() => view('pertemuan1.group2page2'))->name('group2page2');
//     });
// });

Route::get('/dashboard', function () {
    return view('layout.base3');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


Route::prefix('/pertemuan2')->group(function(){
    Route::resource('/crud-song', SongController::class)->parameters(['crud-song' => 'song']);
    Route::resource('/crud-genre', GenreController::class)->parameters(['crud-genre' => 'genre']);
    // Route::resource('/crud-singer', SingerController::class)->parameters(['tampil' => 'crud-singer.tampil']);
    // Route::resource('/crud-singer/tambah', SingerController::class)->parameters(['tambah' => 'crud-singer.tambah']);
    Route::get('/crud-singer', [SingerController::class, 'tampil'])->name('crud-singer.tampil');
    Route::get('/crud-singer/tambah', [SingerController::class, 'tambah'])->name('crud-singer.tambah');
    Route::post('/crud-singer/submit', [SingerController::class, 'submit'])->name('crud-singer.submit');
    Route::get('/crud-singer/edit/{id}', [SingerController::class, 'edit'])->name('crud-singer.edit');
    Route::post('/crud-singer/update/{id}', [SingerController::class, 'update'])->name('crud-singer.update');
    Route::post('/crud-singer/delete/{id}', [SingerController::class, 'delete'])->name('crud-singer.delete');
    // Route to show tracks for a specific singer
    Route::get('/crud-singer/{id}/show', [SingerController::class, 'show'])->name('crud-singer.show');

    // Route::resource('/crud-temp')->(['crud-genre' => 'genre']);


    Route::get('/crud-album', [AlbumController::class, 'tampil'])->name('crud-album.tampil');
    Route::get('/crud-album/tambah', [AlbumController::class, 'tambah'])->name('crud-album.tambah');
    Route::post('/crud-album/submit', [AlbumController::class, 'submit'])->name('crud-album.submit');
    Route::get('/crud-album/edit/{id}', [AlbumController::class, 'edit'])->name('crud-album.edit');
    Route::post('/crud-album/update/{id}', [AlbumController::class, 'update'])->name('crud-album.update');
    Route::post('/crud-album/delete/{id}', [AlbumController::class, 'delete'])->name('crud-album.delete');
    // Route to show tracks for a specific album
    Route::get('/crud-album/{id}/show', [AlbumController::class, 'show'])->name('crud-album.show');

    

    Route::get('/crud-show', [ShowController::class, 'tampil'])->name('crud-show.tampil');
    Route::get('/crud-show/tambah', [ShowController::class, 'tambah'])->name('crud-show.tambah');
    Route::post('/crud-show/submit', [ShowController::class, 'submit'])->name('crud-show.submit');
    Route::get('/crud-show/edit/{id}', [ShowController::class, 'edit'])->name('crud-show.edit');
    Route::post('/crud-show/update/{id}', [ShowController::class, 'update'])->name('crud-show.update');
    Route::post('/crud-show/delete/{id}', [ShowController::class, 'delete'])->name('crud-show.delete');
    // Route to show tracks for a specific show
    Route::get('/crud-show/{id}/show', [ShowController::class, 'show'])->name('crud-show.show');

    
    
    Route::get('/crud-recordlabel', [RecordlabelController::class, 'tampil'])->name('crud-recordlabel.tampil');
    Route::get('/crud-recordlabel/tambah', [RecordlabelController::class, 'tambah'])->name('crud-recordlabel.tambah');
    Route::post('/crud-recordlabel/submit', [RecordlabelController::class, 'submit'])->name('crud-recordlabel.submit');
    Route::get('/crud-recordlabel/edit/{id}', [RecordlabelController::class, 'edit'])->name('crud-recordlabel.edit');
    Route::post('/crud-recordlabel/update/{id}', [RecordlabelController::class, 'update'])->name('crud-recordlabel.update');
    Route::post('/crud-recordlabel/delete/{id}', [RecordlabelController::class, 'delete'])->name('crud-recordlabel.delete');
    // Route to show tracks for a specific recordlabel
    Route::get('/crud-recordlabel/{id}/show', [RecordlabelController::class, 'show'])->name('crud-recordlabel.show');


    Route::get('/crud-playlist', [PlaylistController::class, 'tampil'])->name('crud-playlist.tampil');
    Route::get('/crud-playlist/tambah', [PlaylistController::class, 'tambah'])->name('crud-playlist.tambah');
    Route::post('/crud-playlist/submit', [PlaylistController::class, 'submit'])->name('crud-playlist.submit');
    Route::get('/crud-playlist/edit/{id}', [PlaylistController::class, 'edit'])->name('crud-playlist.edit');
    Route::post('/crud-playlist/update/{id}', [PlaylistController::class, 'update'])->name('crud-playlist.update');
    Route::post('/crud-playlist/delete/{id}', [PlaylistController::class, 'delete'])->name('crud-playlist.delete');
    // Route::get('playlist/{id}', [PlaylistController::class, 'show'])->name('playlist.show');
    Route::post('playlist/{id}/add-song', [PlaylistController::class, 'addSong'])->name('crud-playlist.addSong');
    Route::get('/playlist/{id}', [PlaylistController::class, 'show'])->name('crud-playlist.show');
    Route::post('/playlist/{playlistId}/remove-song/{songId}', [PlaylistController::class, 'removeSong'])
     ->name('crud-playlist.removeSong');
    Route::post('/crud-playlist/submitadmin', [PlaylistController::class, 'submitadmin'])->name('crud-playlist.submitadmin');
    Route::get('/crud-playlist/tambahadmin', [PlaylistController::class, 'tambahadmin'])->name('crud-playlist.tambahadmin');
    

    Route::resource('/crud-episode', EpisodeController::class)->parameters(['crud-episode' => 'episode']);
    

    // Route::resource('/crud-temp')->(['crud-genre' => 'genre']);


    Route::get('/crud-favorite', [FavoriteController::class, 'tampil'])->name('crud-favorite.tampil');
    Route::get('/crud-favorite/tambah', [FavoriteController::class, 'tambah'])->name('crud-favorite.tambah');
    Route::post('/crud-favorite/submit', [FavoriteController::class, 'submit'])->name('crud-favorite.submit');
    Route::get('/crud-favorite/edit/{id}', [FavoriteController::class, 'edit'])->name('crud-favorite.edit');
    Route::post('/crud-favorite/update/{id}', [FavoriteController::class, 'update'])->name('crud-favorite.update');
    Route::post('/crud-favorite/delete/{id}', [FavoriteController::class, 'delete'])->name('crud-favorite.delete');
    Route::post('favorite/{id}/add-song', [FavoriteController::class, 'addSong'])->name('crud-favorite.addSong');
    Route::get('/favorite/{id}', [FavoriteController::class, 'show'])->name('crud-favorite.show');
    Route::post('/favorite/{favoriteId}/remove-song/{songId}', [FavoriteController::class, 'removeSong'])
     ->name('crud-favorite.removeSong');
     


    Route::get('/autocomplete/artists', [SingerController::class, 'autocomplete'])->name('autocomplete.artists');
    Route::get('/autocomplete/albm', [AlbumController::class, 'autocomplete'])->name('autocomplete.albm');
    Route::get('/autocomplete/rl', [RecordlabelController::class, 'autocomplete'])->name('autocomplete.rl');


    // web.php
    Route::get('/artists/search', [SingerController::class, 'search'])->name('artists.search');

    



    
    
    
    Route::get('/temp', fn() => redirect('/'))->name('temp');
    
});


// Route::prefix('/pertemuan3')->group(function(){
//     Route::get('/', [Pertemuan3Controller::class,'index'])->name('pertemuan3.index')->middleware(AuthMiddleware::class);
//     Route::post('/login', [Pertemuan3Controller::class,'login'])->name('pertemuan3.login');
//     Route::post('/register', [Pertemuan3Controller::class,'register'])->name('pertemuan3.register');
//     Route::post('/logout', [Pertemuan3Controller::class,'logout'])->name('pertemuan3.logout');


// });

// Route::get('/pertemuan1/error', fn() => view('pertemuan1.error'))->name('error');

Route::fallback(function () {
    return redirect('/');
});