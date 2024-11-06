<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusySlotsTable extends Migration
{
    public function up()
    {
        Schema::create('busy_slots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consultation_id')->constrained('consultations')->onDelete('cascade'); // Link to consultations
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('date');
            $table->time('time');
            $table->json('busy_times'); // Store selected busy times
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('busy_slots');
    }
}


