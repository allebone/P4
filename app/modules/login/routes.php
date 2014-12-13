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
Route::group(array('before' => 'sentry_user'), function() {
            Route::get('login', array('as' => 'login', 'uses' => 'login\\Login@get_index'));
            Route::get('resetpasswordview/{code}/{id}', array('as' => 'reset_password_view', 'uses' => 'login\\Login@reset_password_view'));
        });
Route::group(array('before' => 'sentry_user', 'before' => 'csrf'), function() {
            Route::post('register', array('as' => 'register_user', 'uses' => 'login\\Login@register'));
            Route::post('login', array('as' => 'login_user', 'uses' => 'login\\Login@login'));
            Route::post('forgot_password', array('as' => 'forgot_password', 'uses' => 'login\\Login@forgot_password'));
            Route::post('resetpassword/{code}/{id}', array('as' => 'reset_password', 'uses' => 'login\\Login@reset_password'));
        });


