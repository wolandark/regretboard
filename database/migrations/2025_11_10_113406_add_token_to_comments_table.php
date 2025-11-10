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
        Schema::table('comments', function (Blueprint $table) {
            // PostgreSQL doesn't support 'after', so we just add the column
            $table->string('token', 64)->nullable();
        });

        // Generate tokens for existing records
        \DB::table('comments')->whereNull('token')->get()->each(function ($comment) {
            \DB::table('comments')
                ->where('id', $comment->id)
                ->update(['token' => bin2hex(random_bytes(32))]);
        });

        // Add unique index (SQLite compatible)
        Schema::table('comments', function (Blueprint $table) {
            $table->unique('token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->dropColumn('token');
        });
    }
};
