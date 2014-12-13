<?php

namespace user;

use DB;

Class User extends \Eloquent {

    public $timestamps = false;
    protected $table = 'users';

    public function task() {
        return $this->hasMany('task\task');
    }

}

?>
