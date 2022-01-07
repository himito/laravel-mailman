<?php

namespace himito\mailman\Tests;

use himito\mailman\Facades\Mailman as MailmanFacade;
use himito\mailman\MailmanServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
    /**
     * Load package service provider.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return himito\mailman\MailmanServiceProvider
     */
    protected function getPackageProviders($app)
    {
        return [MailmanServiceProvider::class];
    }

    protected function getPackageAliases($app)
    {
        return ['Mailman' => MailmanFacade::class];
    }
}
