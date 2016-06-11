<?php

namespace App\Status\User;

use App\User;
use Illuminate\Support\Facades\Session;

/**
 * Created by PhpStorm.
 * User: mithredate
 * Date: 2016-06-11
 * Time: 12:59 PM
 */

abstract class State{

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public abstract function getStatus();

    public abstract function getStatusName();

    public abstract function verify();

    public abstract function setPassword(array $credentials);
    
}