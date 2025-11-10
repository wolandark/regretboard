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
        Schema::table('regrets', function (Blueprint $table) {
            $table->string('token', 64)->nullable()->after('id');
        });

        // Generate tokens for existing records
        \DB::table('regrets')->whereNull('token')->get()->each(function ($regret) {
            \DB::table('regrets')
                ->where('id', $regret->id)
                ->update(['token' => bin2hex(random_bytes(32))]);
        });

        // Add unique index (SQLite compatible)
        Schema::table('regrets', function (Blueprint $table) {
            $table->unique('token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('regrets', function (Blueprint $table) {
            $table->dropColumn('token');
        });
    }
};
