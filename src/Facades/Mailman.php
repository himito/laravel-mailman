<?php

namespace himito\mailman\Facades;

use Illuminate\Support\Facades\Facade;

class Mailman extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'mailman';
    }
}
