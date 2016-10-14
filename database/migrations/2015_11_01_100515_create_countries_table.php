<?php

use Domain\Continent;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('continent_id')->unsigned();
            $table->string('name');
            $table->string('code', 2);

            $table->foreign('continent_id')->references('id')->on('continents')->onDelete('cascade')->onUpdate('cascade');
        });

        $continents = Continent::all()->first();

        /*
         * JSON Source : https://github.com/astockwell/countries-and-provinces-states-regions
         */

        $countries = (object) json_decode(file_get_contents(storage_path('countries/countries.json')), true);

        foreach ($countries as $country) {
            $continent = $continents->where('name', $country['continent']);
            factory(Domain\Country::class)->create([
                'name' => $country['name'],
                'code' => $country['code'],
                'continent_id' => $continents->where('name', $country['continent'])->first()->id,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('countries');
    }
}
