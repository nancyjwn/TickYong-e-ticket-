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
        Schema::table('users', function (Blueprint $table) {
            $table->string('profile_photo')->nullable(); // Tambahkan kolom untuk foto
            $table->string('phone_number')->nullable();
            $table->text('address')->nullable();
            $table->date('birth_date')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable(); // Tambahkan kolom gender
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('profile_photo'); // Hapus kolom foto saat rollback
            $table->dropColumn('phone_number');
            $table->dropColumn('address');
            $table->dropColumn('birth_date');
            $table->dropColumn('gender'); // Hapus kolom saat rollback
        });
    }
};
