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
            // Mengubah kolom created_by untuk memiliki nilai default
            $table->unsignedBigInteger('created_by')->default(1)->change(); // Ganti '1' dengan ID pengguna default jika perlu
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            // Kembalikan perubahan
            $table->unsignedBigInteger('created_by')->nullable()->change();
        });
    }
};
