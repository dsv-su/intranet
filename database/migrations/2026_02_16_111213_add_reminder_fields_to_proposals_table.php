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
        Schema::table('project_proposals', function (Blueprint $table) {
            $table->boolean('reminder')->default(true)->after('files');
            $table->string('last_reminder_type')->nullable()->after('reminder');
            $table->timestamp('last_reminder_sent_at')->nullable()->after('last_reminder_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('project_proposals', function (Blueprint $table) {
            $table->dropColumn(['reminder', 'last_reminder_type', 'last_reminder_sent_at']);
        });
    }
};
