<?php
/**
 * Created by PhpStorm.
 * User: mithredate
 * Date: 2016-06-11
 * Time: 12:57 PM
 */

namespace App\Status\User;


use Illuminate\Support\Facades\Session;

class Registered extends State
{
    


    public function verify()
    {
        Session::push('message',[
            'type' => 'success',
            'content' => 'Thank you for verifying your email address!'
        ]);
        $this->user->setStatus($this->user->verified);
        return true;
    }

    public function setPassword(array $credentials)
    {
//        Session::push('message', [
//           'type' => 'info',
//            'content' => 'You have to verify your email address first'
//        ]);
        abort(403, 'Access denied!');
    }
    

    public function getStatusName()
    {
        return 'registered';
    }

    public function getStatus()
    {
        return 0;
    }
}