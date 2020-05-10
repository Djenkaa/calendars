<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalendarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calendars', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('year')->default(now()->year);
            $table->unsignedInteger('month');
            $table->json('dates');
            $table->unsignedInteger('firstDay');
            $table->unsignedInteger('company_id');
            $table->unsignedFloat('free')->default(0);
            $table->unsignedFloat('lastMinute');
            $table->unsignedFloat('special');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('calendars');
    }
}
