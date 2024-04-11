<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('dashboards', function (Blueprint $table) {
            $table->id();
            $table->uuid('request_id');
            $table->foreignId('workflow_id')->nullable();
            $table->string('name');
            $table->string('state');
            $table->integer('created');
            $table->string('status');
            $table->string('type');
            $table->uuid('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->uuid('manager_id');
            $table->foreign('manager_id')->references('id')->on('users');
            $table->uuid('fo_id');
            $table->foreign('fo_id')->references('id')->on('users');
            $table->uuid('head_id');
            $table->foreign('head_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dashboards');
    }
};
