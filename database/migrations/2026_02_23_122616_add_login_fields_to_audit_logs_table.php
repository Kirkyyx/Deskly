<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('audit_logs', function (Blueprint $table) {
            $table->string('ip_address')->nullable()->after('action');
            $table->string('user_agent')->nullable()->after('ip_address');
            $table->string('status')->default('success')->after('user_agent'); // success | failed
            $table->string('email_attempted')->nullable()->after('status'); // for failed logins
            $table->integer('failed_attempts')->default(0)->after('email_attempted');
        });
    }

    public function down(): void
    {
        Schema::table('audit_logs', function (Blueprint $table) {
            $table->dropColumn(['ip_address','user_agent','status','email_attempted','failed_attempts']);
        });
    }
};