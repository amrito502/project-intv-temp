<?php

namespace App\Helper\Ui;

use Illuminate\Support\Facades\Session;


class FlashMessageGenerator
{
    public static function generate($class, $message)
    {
        Session::flash('class_name', $class);
        Session::flash('message', $message);
    }
}
