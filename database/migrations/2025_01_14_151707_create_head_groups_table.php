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
        Schema::create('head_groups', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('request_id')->nullable();
            $table->foreignId('workflow_id')->nullable();
            $table->json('unit_heads');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('head_groups');
    }
};
