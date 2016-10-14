<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWorshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('worships', function (Blueprint $table) {
            $table->bigInteger('address_id')->unsigned();
            $table->string('title')->nullable();
            $table->timestamp('start');
            $table->timestamp('end')->nullable();
            $table->enum('week', ['first', 'second', 'third', 'fourth', 'fifth', 'last', 'everyWeek'])->nullable()->default('everyWeek');
            $table->enum('days', ['everyDay', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'everySunday', 'everyMonday', 'everyTuesday', 'everyWednesday', 'everyThursday', 'everyFriday', 'everySaturday'])->nullable()->default('everySunday');
            $table->boolean('status')->default(false);

            $table->foreign('address_id')->references('id')->on('addresses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('worships');
    }
}
