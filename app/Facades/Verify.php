<?php
/**
 * Created by PhpStorm.
 * User: mithredate
 * Date: 2016-06-13
 * Time: 4:07 PM
 */

namespace App\Facades;


use Illuminate\Support\Facades\Facade;

class Verify extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'auth.verify';
    }
}