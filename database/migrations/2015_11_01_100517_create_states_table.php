<?php

use Domain\Country;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('states', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('country_id')->unsigned();
            $table->string('name');
            $table->string('code', 18)->unique();

            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade')->onUpdate('cascade');
        });

        $countries = Country::all();

        /*
         * JSON Source : https://github.com/astockwell/countries-and-provinces-states-regions
         */

        $diretorio = dir(storage_path('countries/states'));

        while ($arquivo = $diretorio->read()) {
            if ($arquivo != '.' && $arquivo != '..') {
                $states = (object) json_decode(file_get_contents(storage_path('countries/states/'.$arquivo)), true);
                foreach ($states as $state) {
                    factory(Domain\State::class)->create([
                        'name' => $state['name'],
                        'code' => $state['code'],
                        'country_id' => $countries->where('code', substr($state['code'], 0, 2))->first()->id,
                    ]);
                }
            }
        }

        $diretorio->close();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('states');
    }
}
