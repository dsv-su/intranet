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
        Schema::create('dsv_budgets', function (Blueprint $table) {
            $table->id();
            $table->json('research_area');
            $table->integer('preapproved_total');
            $table->decimal('budget_total');
            $table->decimal('cost_total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dsv_budgets');
    }
};
