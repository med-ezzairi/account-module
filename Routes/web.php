<?php

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

use Illuminate\Support\Facades\Route;

Route::prefix('account')->middleware(['auth', 'role:admin'])->name('account.')->group(function() {
    
    Route::get('/', 'AccountController@home')->name('home');
    
    /*
     | Groups
     |--------------------------------------------------------------------------
     | 
     | 
     | 
     */
    Route::get('/groups', 'GroupController@index')->name('groups.index');
    //Route::get('/groups/create', 'GroupController@create')->name('groups.create');
    Route::post('/groups', 'GroupController@store')->name('groups.store');
    Route::get('/groups/{id}', 'GroupController@show')->name('groups.show');
    Route::post('/groups/{id}/permissions', 'GroupController@permissions')->name('groups.permissions');
    Route::delete('/groups/{id}', 'GroupController@delete')->name('groups.delete');
    Route::get('/groups/{id}/users', 'GroupController@users')->name('groups.users');
    Route::delete('/groups/{id}/users', 'GroupController@removeUsers')->name('groups.users');
    Route::post('/groups/{id}/users', 'GroupController@addUsers')->name('groups.users');
    
    
    /*
     | User's Groups and Permissions Affectation
     |--------------------------------------------------------------------------
     |
     */
    Route::get('/affectations', 'AffectationController@index')->name('affectations.index');
    Route::post('/affectations/search', 'AffectationController@search')->name('affectations.search');
    Route::post('/affectations/groups', 'AffectationController@groups')->name('affectations.groups');
    Route::post('/affectations/permissions', 'AffectationController@permissions')->name('affectations.permissions');
    
    
    
});
