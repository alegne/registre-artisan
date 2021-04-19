<?php

use App\Http\Controllers\ArtisantController;
use Illuminate\Support\Facades\Auth;
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

/*Route::get('/', function () {
    return view('welcome');
});*/



//Route::get('/home', 'HomeController@index')->name('home');
Auth::routes();

    //gestion user routes
    Route::get('/utilisateurs','UsersController@index')->name('gestionUsers');
    Route::get('/DeleteUtilisateurs/{id}','UsersController@delete')->name('gestionUsersDelete');
    Route::post('/addUtilisateurs','UsersController@add')->name('gestionUsersAdd');
    Route::post('/UpdateUtilisateurs/{id}','UsersController@update')->name('gestionUsersUpdate');

    //custom routes
    Route::get('/','ArtisantController@accueil')->name('homeArtisant');

    Route::get('deleteArtisant/{id}', 'ArtisantController@delete')->name('suppArtisant');
    Route::get('/createArtisant', 'ArtisantController@loadCreateArtisant')->name('createArtisant');
    Route::post('/insertArtisant', 'ArtisantController@insertArtisant')->name('insertArtisant');
    Route::post('/updateArtisant', 'ArtisantController@updateArtisant')->name('updateArtisant');
    Route::get('/detailsArtisant/{id}', 'ArtisantController@detailsArtisant')->name('detailsArtisant');
    Route::get('/modificationArtisant/{id}', 'ArtisantController@loadModifArtisant')->name('modificationArtisant');


//Route vers le controller Metier
    Route::get('/createMetier', 'MetierController@index')->name('createMetier');
    Route::post('/insertMetier', 'MetierController@insert')->name('insertMetier');
    Route::get('deleteMetier/{id}', 'MetierController@delete')->name('suppMetier');
    Route::get('deleteFiliere/{id}', 'MetierController@deletefil')->name('suppFiliere');
    Route::post('/updateMetier', 'MetierController@update')->name('updateMetier');

//groupe de route pour le vue
    Route::group(['prefix'=>'antananarivo'], function(){
        Route::get('/globalAntananarivo','ArtisantController@globalTana')->name('globalTana');
        Route::get('/analamanga','ArtisantController@analamanga')->name('analamanga');
        Route::get('/vakinankaratra','ArtisantController@vakinankaratra')->name('vakinankaratra');
        Route::get('/itasy','ArtisantController@itasy')->name('itasy');
        Route::get('/bongolava','ArtisantController@bongolava')->name('bongolava');
    });

    Route::group(['prefix'=>'fianrantsoa'], function(){
        Route::get('/globalFianarantsoa','ArtisantController@globalFianar')->name('globalFianar');
        Route::get('/HM','ArtisantController@hautematsiatsa')->name('hautematsiatsa');
        Route::get('/amorimania','ArtisantController@amoronimania')->name('amoronimania');
        Route::get('/ihorombe','ArtisantController@ihorombe')->name('ihorombe');
        Route::get('/vvfitov','ArtisantController@vatovavyfitovinany')->name('vatovavyfitovinany');
        Route::get('/atsimoatsinanana','ArtisantController@atsimoatsinanana')->name('atsimoatsinanana');
    });

    Route::group(['prefix'=>'mahajanga'], function(){
        Route::get('/globalmahajanga','ArtisantController@globalMahaj')->name('globalMahaj');
        Route::get('/betsiboka','ArtisantController@betsiboka')->name('betsiboka');
        Route::get('/boeny','ArtisantController@boeny')->name('boeny');
        Route::get('/melaky','ArtisantController@melaky')->name('melaky');
        Route::get('/sofia','ArtisantController@sofia')->name('sofia');
    });

    Route::group(['prefix'=>'antsiranana'], function(){
        Route::get('/globalantsiranana','ArtisantController@globalAntsir')->name('globalAntsir');
        Route::get('/diana','ArtisantController@diana')->name('diana');
        Route::get('/sava','ArtisantController@sava')->name('sava');
    });

    Route::group(['prefix'=>'toliara'], function(){
        Route::get('/globaltoliara','ArtisantController@globalTol')->name('globalTol');
        Route::get('/atsimoandrefana','ArtisantController@atsimoandrefana')->name('atsimoandrefana');
        Route::get('/menabe','ArtisantController@menabe')->name('menabe');
        Route::get('/anosy','ArtisantController@anosy')->name('anosy');
        Route::get('/androy','ArtisantController@androy')->name('androy');
    });

    Route::group(['prefix'=>'toamasina'], function(){
        Route::get('/globaltoamasina','ArtisantController@globalToam')->name('globalToam');
        Route::get('/atsinanana','ArtisantController@atsinanana')->name('atsinanana');
        Route::get('/analanjirofo','ArtisantController@analanjirofo')->name('analanjirofo');
        Route::get('/alaotramangoro','ArtisantController@alaotramangoro')->name('alaotramangoro');
    });