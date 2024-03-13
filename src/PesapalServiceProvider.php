<?php

namespace ArtisanElevated\Pesapal;

use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use ArtisanElevated\Pesapal\Commands\PesapalAuthCommand;

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
            ->hasMigration(migrationFileName: 'create_pesapal_tables')
            ->hasCommand(commandClassName: PesapalAuthCommand::class)
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->publishMigrations()
                    ->askToStarRepoOnGitHub('artisanelevated/laravel-pesapal');
            });
    }
}
