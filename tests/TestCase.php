<?php

namespace Sashalenz\NovaPoshtaWireformsFields\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;
use Sashalenz\NovaPoshtaWireformsFields\NovaPoshtaWireformsFieldsServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Sashalenz\\NovaPoshtaWireformsFields\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            NovaPoshtaWireformsFieldsServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_nova-poshta-wireforms-fields_table.php.stub';
        $migration->up();
        */
    }
}
