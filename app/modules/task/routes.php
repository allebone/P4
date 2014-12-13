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
            Route::get('/', array('as' => 'tasks', 'uses' => 'task\\Tasks@getIndex'));
            Route::get('tasks', array('as' => 'tasks', 'uses' => 'task\\Tasks@getIndex'));
            Route::get('incompleteTask', array('as' => 'incompleteTask', 'uses' => 'task\\Tasks@getIncomplete'));
            Route::get('completeTask', array('as' => 'completeTask', 'uses' => 'task\\Tasks@getComplete'));
            Route::get('tasks/create', array('as' => 'task_create', 'uses' => 'task\\Tasks@create'));
            Route::get('tasks/change_setting', array('as' => 'changeSetting', 'uses' => 'task\\Tasks@changeSetting'));
            Route::get('tasks/{id}', array('as' => 'task_show', 'uses' => 'task\\Tasks@show'));
            Route::get('tasks/{id}/destroy', array('as' => 'task_delete', 'uses' => 'task\\Tasks@destroy'));
            Route::get('tasks/{id}/changeStatus', array('as' => 'task_complete', 'uses' => 'task\\Tasks@changeStatus'));
            Route::get('tasks/{id}/email', array('as' => 'task_email', 'uses' => 'task\\Tasks@taskEmail'));
            Route::get('tasks/{id}/edit', array('as' => 'task_edit', 'uses' => 'task\\Tasks@edit'));
            Route::get('logout', array('as' => 'logout', 'uses' => 'login\\Login@logout'));
            View::composer(array('task::index', 'task::incomplete', 'task::complete'), function($view) {
                        $view->with('complete_count', task\Task::whereCompletedAndUserId('1', Sentry::getUser()->id)->count())
                                ->with('incomplete_count', task\Task::whereCompletedAndUserId('0', Sentry::getUser()->id)->count());
                    });
        });

Route::group(array('before' => 'auth_sentry', 'before' => 'csrf'), function() {
            Route::post('tasks/insert', array('as' => 'inserttask', 'uses' => 'task\\Tasks@insert'));
            Route::post('tasks/{id}/update', array('as' => 'updatetask', 'uses' => 'task\\Tasks@update'));
            Route::post('tasks/{id}/update_user', array('as' => 'updateUser', 'uses' => 'login\\Login@updateUser'));
        });



