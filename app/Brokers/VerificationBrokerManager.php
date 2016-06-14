<?php

namespace App\Brokers;
use Illuminate\Auth\Passwords\PasswordBrokerManager;

/**
 * Created by PhpStorm.
 * User: mithredate
 * Date: 2016-06-13
 * Time: 4:09 PM
 */
class VerificationBrokerManager extends PasswordBrokerManager
{
    /**
     * Get the password broker configuration.
     *
     * @param  string  $name
     * @return array
     */
    protected function getConfig($name)
    {
        return $this->app['config']["auth.verify.{$name}"];
    }
}