<?php

namespace ArtisanElevated\Pesapal\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;
use ArtisanElevated\Pesapal\PesapalServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'ArtisanElevated\\Pesapal\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            PesapalServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app): void
    {
        config()->set('app.key', 'base64:E3SoAOQeMq0UyI7aBZzBPTSAXqp485oM6xqxOtvKhDA=');
        config()->set('database.default', 'testing');
        config()->set('app.timezone', 'Africa/Nairobi');
        // @see https://developer.pesapal.com/api3-demo-keys.txt
        config()->set('pesapal.pesapal_live', false);
        config()->set('pesapal.consumer_key', 'qkio1BGGYAXTu2JOfm7XSXNruoZsrqEW');
        config()->set('pesapal.consumer_secret', 'osGQ364R49cXKeOYSpaOnT++rHs=');

        $migration = include __DIR__.'/../database/migrations/create_pesapal_tokens_table.php.stub';
        $migration->up();
    }
}
