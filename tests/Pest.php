<?php

use NjoguAmos\Pesapal\Requests\CreatePesapalIpn;
use NjoguAmos\Pesapal\Requests\CreatePesapalOrder;
use NjoguAmos\Pesapal\Requests\CreatePesapalToken;
use NjoguAmos\Pesapal\Requests\GetPesapalIpns;
use NjoguAmos\Pesapal\Requests\GetPesapalTransactionStatus;
use NjoguAmos\Pesapal\Tests\TestCase;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Saloon\MockConfig;
use Saloon\Config;

uses(TestCase::class)->in(__DIR__);


MockConfig::setFixturePath(path: 'tests/Fixtures');
Config::preventStrayRequests();
//MockConfig::throwOnMissingFixtures();

MockClient::global(mockData: [
    CreatePesapalToken::class          => MockResponse::fixture(name: 'CreatePesapalToken'),
    CreatePesapalIpn::class            => MockResponse::fixture(name: 'CreatePesapalIpn'),
    GetPesapalIpns::class              => MockResponse::fixture(name: 'GetPesapalIpns'),
    CreatePesapalOrder::class          => MockResponse::fixture(name: 'CreatePesapalOrder'),
    GetPesapalTransactionStatus::class => MockResponse::fixture(name: 'GetPesapalTransactionStatus'),
]);
