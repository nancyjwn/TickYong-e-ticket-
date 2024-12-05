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
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('ticket_quota');
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->integer('ticket_quota')->default(0); // Tambahkan kembali kolom jika rollback
        });
    }
};
