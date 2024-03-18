<?php

use NjoguAmos\Pesapal\Tests\TestCase;
use Saloon\MockConfig;

uses(TestCase::class)
    ->beforeAll(fn () => MockConfig::setFixturePath('tests/Fixtures'))
    ->in(__DIR__);
