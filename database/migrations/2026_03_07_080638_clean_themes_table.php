<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CleanThemesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('themes', function (Blueprint $table) {

            $table->dropColumn([
                'color',
                'bg_color',
                'border_color',
                'text_color'
            ]);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('themes', function (Blueprint $table) {

            $table->string('color')->nullable();
            $table->string('bg_color')->nullable();
            $table->string('border_color')->nullable();
            $table->string('text_color')->nullable();

        });
    }
}
