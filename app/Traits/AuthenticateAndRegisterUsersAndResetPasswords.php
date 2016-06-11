<?php namespace App\Traits;

use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Foundation\Auth\ResetsPasswords;

/**
 * Created by PhpStorm.
 * User: mithredate
 * Date: 2016-06-11
 * Time: 3:36 AM
 */

trait AuthenticateAndRegisterUsersAndResetPasswords{
    use AuthenticatesAndRegistersUsers, ResetsPasswords{
        AuthenticatesAndRegistersUsers::getGuard insteadof ResetsPasswords;
        AuthenticatesAndRegistersUsers::guestMiddleware insteadof ResetsPasswords;
        AuthenticatesAndRegistersUsers::redirectPath insteadof ResetsPasswords;
    }
}