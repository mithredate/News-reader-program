<?php
/**
 * Created by PhpStorm.
 * User: mithredate
 * Date: 2016-06-11
 * Time: 1:05 PM
 */

namespace App\Status\User;


use App\User;

class UserStatusBroker
{

    public static function getStatus(User $user, $status){
        switch ($status){
            case 0:
                return new Registered($user);
            case 1:
                return new Verified($user);
            case 2:
                return new Authenticated($user);
            default:
                //TODO: Should throw appropriate exception
                return null;
        }
    }

}