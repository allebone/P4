<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the Closure to execute when that URI is requested.
  |
 */

Route::group(array('before' => 'auth_sentry'), function() {
            Route::get('tasks', array('as' => 'tasks', 'uses' => 'task\\Tasks@getIndex'));
        });
Route::group(array('before' => 'sentry_user'), function() {
            Route::get('login', array('as' => 'login', 'uses' => 'login\\Login@get_index'));
        });


