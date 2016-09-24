<?php

class TestCase extends Laravel\Lumen\Testing\TestCase
{
    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }

    public function artisanMigrateRefresh()
	{
	    Artisan::call('migrate');
	}

	public function artisanMigrateReset()
	{
	    Artisan::call('migrate:reset');
	}
}
