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
        Schema::table('dashboards', function (Blueprint $table) {
            $table->uuid('vice_id')->after('head_id');
            $table->foreign('vice_id')->references('id')->on('users');
            $table->boolean('multiple_heads')->default(false)->after('user_id');
            $table->json('unit_heads')->nullable()->after('vice_id');
            $table->json('unit_head_approved')->nullable()->after('vice_id');
            $table->uuid('manager_id')->nullable()->change();
            $table->uuid('head_id')->nullable()->change();
            $table->uuid('fo_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dashboards', function (Blueprint $table) {
            $table->dropForeign(['vice_id']);
            $table->dropColumn('vice_id');
            $table->dropColumn('multiple_heads');
            $table->dropColumn('unit_heads');
            $table->dropColumn('unit_head_approved');
            $table->uuid('manager_id')->nullable(false)->change();
            $table->uuid('head_id')->nullable(false)->change();
            $table->uuid('fo_id')->nullable(false)->change();
        });
    }
};
