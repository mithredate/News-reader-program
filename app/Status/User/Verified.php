<?php
/**
 * Created by PhpStorm.
 * User: mithredate
 * Date: 2016-06-11
 * Time: 12:57 PM
 */

namespace App\Status\User;



use Illuminate\Support\Facades\Session;

class Verified extends State
{

    public function verify()
    {
        Session::push('message',[
            'type' => 'success',
            'content' => 'You have already verified your email address!'
        ]);

        Session::push('message', [
           'type' => 'info',
            'content' => 'You have to set a password to be able to access your account!'
        ]);

        return true;
    }

    public function setPassword(array $credentials)
    {
        $this->user->setStatus($this->user->authenticated);
        return true;
    }


    public function getStatusName()
    {
        return 'verified';
    }

    public function getStatus()
    {
        return 1;
    }
}