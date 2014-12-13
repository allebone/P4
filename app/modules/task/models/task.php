<?php

namespace task;

use DB,
    Sentry;

Class Task extends \Eloquent {

    public $timestamps = false;

    public function user() {
        return $this->belongsTo('user\User');
    }

}

?>
