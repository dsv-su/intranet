<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('travel_requests', function (Blueprint $table) {
            $table->uuid('id')->primary();;
            $table->string('name');
            $table->integer('created');
            $table->string('state');
            $table->text('purpose');
            $table->string('project');
            $table->string('country');
            $table->boolean('paper')->default(false);
            $table->string('contribution')->nullable();
            $table->string('other')->nullable();
            $table->integer('departure');
            $table->integer('return');
            $table->integer('days')->nullable();
            $table->integer('flight')->nullable();
            $table->integer('hotel')->nullable();
            $table->integer('daily')->nullable();
            $table->integer('conference')->nullable();
            $table->integer('other_costs')->nullable();
            $table->integer('total');
            $table->foreignId('manager_comment_id')->nullable()->constrained();
            $table->foreignId('fo_comment_id')->nullable()->constrained();
            $table->foreignId('head_comment_id')->nullable()->constrained();
            $table->timestamps();
        });

        DB::statement(
            'ALTER TABLE travel_requests ADD FULLTEXT fulltext_index(name, purpose, project)'
        );
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('travel_requests');
    }
};
