<?php

namespace ArtisanElevated\Pesapal;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use ArtisanElevated\Pesapal\Commands\PesapalCommand;

class PesapalServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name(name: 'laravel-pesapal')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration(migrationFileName: 'create_laravel-pesapal_table')
            ->hasCommand(commandClassName: PesapalCommand::class);
    }
}
