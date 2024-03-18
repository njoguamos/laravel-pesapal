<?php

use NjoguAmos\Pesapal\Requests\CreatePesapalIpn;
use NjoguAmos\Pesapal\Requests\CreatePesapalToken;
use NjoguAmos\Pesapal\Requests\GetPesapalIpns;
use NjoguAmos\Pesapal\Tests\TestCase;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Saloon\MockConfig;

uses(TestCase::class)
    ->beforeAll(fn () => MockConfig::setFixturePath('tests/Fixtures'))
    ->beforeAll(function () {
        MockClient::global(mockData: [
            CreatePesapalToken::class => MockResponse::fixture(name: 'CreatePesapalToken'),
            CreatePesapalIpn::class   => MockResponse::fixture(name: 'CreatePesapalIpn'),
            GetPesapalIpns::class     => MockResponse::fixture(name: 'GetPesapalIpns'),
        ]);
    })
    ->in(__DIR__);
