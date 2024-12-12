<?php

namespace NjoguAmos\Pesapal;

use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use NjoguAmos\Pesapal\Commands\PesapalAuthCommand;

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
            ->hasMigrations([
                'create_pesapal_tables',
                'modify_pesapal_access_token',
            ] )
            ->hasCommand(commandClassName: PesapalAuthCommand::class)
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->publishMigrations()
                    ->askToStarRepoOnGitHub('NjoguAmos/laravel-pesapal');
            });
    }
}
