<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void {
        Schema::table('students', function (Blueprint $table) {
            $table->string('email')->unique()->nullable()->after('gmail');
            $table->string('password')->nullable()->after('email');
        });
    }

    public function down(): void {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn(['email', 'password']);
        });
    }
};
