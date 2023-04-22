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
        Schema::table('personal_access_tokens', function (Blueprint $table) {
            $table->string('token_plaintext', 255)->unique()->after('token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('personal_access_tokens', 'token_plaintext')) {
            Schema::table('personal_access_tokens', function (Blueprint $table) {
                $table->$table->dropColumn('token_plaintext');
            });
        }
    }
};
