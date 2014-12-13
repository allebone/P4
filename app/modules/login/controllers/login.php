<?php

namespace login;

use View,
    Sentry,
    Input,
    Validator,
    Response,
    Mail,
    Redirect;

class Login extends \BaseController {

    public function get_index() {
        return View::make('login::login');
    }

    public function register() {
        $rules = array(
            'reg_eml' => 'required|email',
            'reg_pwd' => 'required',
            'reg_cpwd' => 'required|same:reg_pwd',
        );
        $message = array(
            'reg_eml.required' => 'The Email Field Is Required',
            'reg_cpwd.required' => 'The Confirm Password Field Is Required',
            'reg_eml.email' => 'The Email Field Must Contain Valid E-mail Address.',
            'reg_pwd.required' => 'The Password Field Is Required',
            'reg_cpwd.same' => 'The Confirm Password Field Must Same As Password Field.'
        );
        $validator = Validator::make(Input::all(), $rules, $message);
        if ($validator->fails()) {
            return Response::json([
                        'success' => false,
                        'errors' => $validator->errors()->toArray()
            ]);
        } else {
            try {
                Sentry::createUser(array(
                    'email' => Input::get('reg_eml'),
                    'password' => Input::get('reg_pwd'),
                    'activated' => true,
                ));
                return Response::json([
                            'success' => True,]);
            } catch (\Cartalyst\Sentry\Users\UserExistsException $e) {
                return Response::json([
                            'success' => False,
                            'user_exist' => 'User with this login already exists.']);
            }
        }
    }

    public function updateUser($id) {
        $rules = array(
            'reg_eml' => 'required|email',
            'reg_cpwd' => 'sometimes|required_with:reg_pwd|same:reg_pwd',
        );
        $message = array(
            'reg_eml.required' => 'The Email Field Is Required',
            'reg_eml.email' => 'The Email Field Must Contain Valid E-mail Address.',
            'reg_cpwd.same' => 'The Confirm Password Field Must Same As Password Field.',
            'reg_cpwd.required_with' => 'The Confirm Password Field Is Required'
        );
        $validator = Validator::make(Input::all(), $rules, $message);
        if ($validator->fails()) {
            return Response::json([
                        'success' => false,
                        'errors' => $validator->errors()->toArray()
            ]);
        } else {
            try {
                $user = Sentry::findUserById($id);
                $user->email = Input::get('reg_eml');
                if (Input::get('reg_pwd'))
                    $user->password = Input::get('reg_pwd');
                $user->save();
                return Response::json([
                            'success' => True,]);
            } catch (\Cartalyst\Sentry\Users\UserExistsException $e) {
                return Response::json([
                            'success' => False,
                            'user_exist' => 'User with this login already exists.']);
            } catch (\Cartalyst\Sentry\Users\UserNotFoundException $e) {
                return Response::json([
                            'success' => False,
                            'user_not_found' => 'User with this login already exists.']);
            }
        }
    }

    public function login() {
        $rules = array(
            'log_eml' => 'required|email',
            'log_pwd' => 'required',
        );
        $message = array(
            'log_eml.required' => 'The Email Field Is Required',
            'log_eml.email' => 'The Email Field Must Contain Valid E-mail Address.',
            'log_pwd.required' => 'The Password Field Is Required',
        );
        $validator = Validator::make(Input::all(), $rules, $message);
        if ($validator->fails()) {
            return Response::json([
                        'success' => false,
                        'errors' => $validator->errors()->toArray()
            ]);
        } else {
            try {
                Sentry::authenticate(array(
                    'email' => Input::get('log_eml'),
                    'password' => Input::get('log_pwd'),
                ));
                return Response::json([
                            'success' => True,]);
            } catch (\Cartalyst\Sentry\Users\WrongPasswordException $e) {
                return Response::json([
                            'success' => False,
                            'wrong_pwd' => 'Wrong Email or Password']);
            } catch (\Cartalyst\Sentry\Users\UserNotFoundException $e) {
                return Response::json([
                            'success' => False,
                            'wrong_user' => 'Wrong Email or Password']);
            }
        }
    }

    public function forgot_password() {
        $rules = array(
            'frgt_eml' => 'required|email',
        );
        $message = array(
            'frgt_eml.required' => 'The Email Field Is Required',
            'frgt_eml.email' => 'The Email Field Must Contain Valid E-mail Address.',
        );
        $validator = Validator::make(Input::all(), $rules, $message);
        if ($validator->fails()) {
            return Response::json([
                        'success' => false,
                        'errors' => $validator->errors()->toArray()
            ]);
        } else {
            try {
                $user = Sentry::findUserByLogin(Input::get('frgt_eml'));
                $resetCode = $user->getResetPasswordCode();
                Mail::send('login::mail.reset', array('code' => $resetCode, 'id' => $user->getId()), function($message) {
                            $message->to(Input::get('frgt_eml'))->subject('Reset Password For Task Management System');
                        });
                return Response::json([
                            'success' => True,
                            'user' => $user]);
            } catch (\Cartalyst\Sentry\Users\UserNotFoundException $e) {
                return Response::json([
                            'success' => False,
                            'wrong_user' => 'User not found with this email address.']);
            }
        }
    }

    public function reset_password_view($id, $code) {
        return view::make('login::reset_password')->with(array('id' => $id, 'code' => $code));
    }

    public function reset_password($id, $code) {
        $rules = array(
            'rst_pwd' => 'required',
            'rst_c_pwd' => 'required|same:rst_pwd',
        );
        $message = array(
            'rst_pwd.required' => 'The New Password Field Is Required',
            'rst_c_pwd.required' => 'The Confirm Password Field Is Required',
            'rst_c_pwd.same' => 'The Confirm Password Must Same as New Password Field'
        );
        $validator = Validator::make(Input::all(), $rules, $message);
        if ($validator->fails()) {
            return Response::json([
                        'success' => false,
                        'errors' => $validator->errors()->toArray()
            ]);
        } else {
            $user = Sentry::findUserById($id);
            if ($user->checkResetPasswordCode($code)) {
                if ($user->attemptResetPassword($code, Input::get('rst_c_pwd'))) {
                    return Response::json([
                                'success' => true,
                    ]);
                } else {
                    return Response::json([
                                'success' => false,
                                'message' => 'Somthing Went Wrong..'
                    ]);
                }
            }
        }
    }

    public function logout() {
        Sentry::logout();
        return Redirect::route('login');
    }

}

?>
