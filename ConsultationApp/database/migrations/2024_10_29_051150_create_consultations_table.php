<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('consultations', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('course');
        $table->string('purpose');
        $table->string('consultant');  // Either 'department_head' or 'admin_consultant'
        $table->string('meeting_mode');
        $table->string('online_platform')->nullable();
        $table->datetime('schedule');  // Changed from date to datetime
        $table->string('status')->default('pending');  // pending, approved, or declined
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultations');
    }
};
