<?php
/**
 * Created by PhpStorm.
 * User: mithredate
 * Date: 2016-06-11
 * Time: 12:58 PM
 */

namespace App\Status\User;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Authenticated extends State
{

    public function setPassword(array $credentials)
    {
        Session::push('message', [
            'type' => 'info',
            'content' => 'You have already setup your account!'
        ]);
        Auth::login($this->user);
        return redirect('home');
    }
    

    public function getStatusName()
    {
        return 'authenticated';
    }

    public function getStatus()
    {
        return 2;
    }

    public function verify()
    {
        Session::push('message',[
            'type' => 'success',
            'content' => 'You have already verified your email address!'
        ]);
        Auth::login($this->user);
        return redirect('home');
    }
}