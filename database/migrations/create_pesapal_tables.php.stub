<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pesapal_tokens', function (Blueprint $table) {
            $table->id();
            $table->string('access_token');
            $table->timestamp('expires_at');
            $table->timestamps();
        });

         Schema::create('pesapal_ipns', function (Blueprint $table) {
            $table->id();
            $table->string('url');
            $table->uuid('ipn_id');
            $table->unsignedTinyInteger('type');
            $table->unsignedTinyInteger('status')->nullable();
            $table->timestamps();
        });
    }
};
