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
            // Tambahkan kolom role jika belum ada
            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role')->nullable()->after('password');
            } else {
                // Kalau sudah ada, ubah menjadi nullable
                $table->string('role')->nullable()->change();
            }
        });

        // Update semua user yang punya role 'anggota' jadi null (guest)
        \App\Models\User::where('role', 'anggota')->update(['role' => null]);
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'role')) {
                // Kembalikan default 'anggota' kalau rollback
                $table->string('role')->default('anggota')->change();
            }
        });
    }
};
