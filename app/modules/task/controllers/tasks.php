<?php

namespace task;

use View,
    Response,
    Validator,
    Input,
    Mail,
    Sentry,
    Request,
    Session;

Class Tasks extends \BaseController {

    public function getIndex() {

        if (Request::ajax()) {

            $task = Task::where('user_id', Sentry::getUser()->id)->orderBy('id','desc')->paginate(10);

            $table_view = View::make('task::tasktable')->with(array('tasks' => $task))->renderSections();
            $links = $task->links()->renderSections();
            return Response::json(array('task' => $table_view, 'links' => $links));
        }
        return View::make('task::index');
    }

    public function getCount($incomplete = '', $complete = '') {
        $complete = Task::where('completed', '=', '0')->count();
        $incomplete = Task::where('completed', '=', '1')->count();
    }

    public function getIncomplete() {

        if (Request::ajax()) {


            $task = Task::whereCompletedAndUserId('0', Sentry::getUser()->id)->paginate(10);
            $table_view = View::make('task::tasktable')->with(array('tasks' => $task))->renderSections();
            $links = $task->links()->renderSections();
            return Response::json(array('task' => $table_view, 'links' => $links));

            //return View::make('task::tasktable')->with(array('tasks' => Task::whereCompletedAndUserId('0', Sentry::getUser()->id)->get()));
        }
        return View::make('task::incomplete');
    }

    public function getComplete() {

        if (Request::ajax()) {

            $task = Task::whereCompletedAndUserId('1', Sentry::getUser()->id)->paginate(10);
            $table_view = View::make('task::tasktable')->with(array('tasks' => $task))->renderSections();
            $links = $task->links()->renderSections();
            return Response::json(array('task' => $table_view, 'links' => $links));
        }
        return View::make('task::complete');
    }

    public function changeSetting() {

        if (Request::ajax()) {
            return View::make('task::change_setting')->with(array('user' => Sentry::getUser()->id));
        }
        return View::make('task::change_setting');
    }

    public function create() {
        return View::make('task::create');
    }

    public function show($id) {
        return View::make('task::show')->with('task', Task::find($id));
    }

    public function edit($id) {
        return View::make('task::create')->with('edit_task', Task::find($id));
    }

    public function insert() {
        $rules = array(
            'title' => 'required',
        );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Response::json([
                        'success' => false,
                        'errors' => $validator->errors()->toArray()
            ]);
        } else {
            $task = new Task();
            $user = Sentry::getUser();
            $task->start_date = date('Y-m-d h:i:s');
            $task->title = Input::get('title');
            $task->user_id = $user->id;            
            if (Input::get('email_task')) {
                Mail::send('task::taskmail', array('title' => Input::get('title'), 'description' => Input::get('description'), 'created' => date('d-m-Y h:i:s')), function($message) use ($user) {
                            $message->to($user->email)->subject('Your Task');
                        });
            }
            $task->save();

            return Response::json([
                        'success' => true
            ]);
        }
    }

    public function update($id) {
        $rules = array(
            'title' => 'required',
        );
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Response::json([
                        'success' => false,
                        'errors' => $validator->errors()->toArray()
            ]);
        } else {
            $task = Task::find($id);
            $user = Sentry::getUser();
            $task->user_id = $user->id;
            $task->title = Input::get('title');            
            if (Input::get('email_task')) {
                Mail::send('task::taskmail', array('title' => Input::get('title'), 'description' => Input::get('description'), 'created' => $task->start_date), function($message) use ($user) {
                            $message->to($user->email)->subject('Edited Task');
                        });
            }
            if (Input::get('complete_task')) {
                $task->completed = '1';
                $task->end_date = date('Y-m-d h:i:s');
            } else {
                $task->completed = '0';
                $task->end_date = NULL;
            }
            $task->save();
            return Response::json([
                        'success' => true,
                        'message' => 'Task Updated Successfully!'
            ]);
        }
    }

    public function destroy($id) {
        // delete
        $task = Task::find($id);
        if ($task) {
            $task->delete();
            // redirect
            return 'success';
        } else {
            return 'fail';
        }
    }

    public function changeStatus($id) {
        // delete
        $task = Task::find($id);
        if ($task) {
            $task->completed = '1';
            $task->end_date = date('Y-m-d H:i:s');
            $task->save();
            // redirect
            return 'success';
        } else {
            return 'fail';
        }
    }

    public function taskEmail($id) {
        // delete
        $task = Task::find($id);
        if ($task) {
            Mail::send('task::taskmail', array('title' => $task->title, 'description' => $task->description, 'created' => $task->start_date), function($message) use($task) {
                        $message->to($task->user()->first()->email)->subject('Task');
                    });
            // redirect
            return 'success';
        } else {
            return 'fail';
        }
    }

}

?>
