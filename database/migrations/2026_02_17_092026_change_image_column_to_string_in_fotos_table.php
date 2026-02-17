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
        Schema::table('fotos', function (Blueprint $table) {
            $table->string('image', 500)->change(); // adjust length as needed
        });
    }

    public function down()
    {
        Schema::table('fotos', function (Blueprint $table) {
            $table->tinyInteger('image')->change(); // revert if necessary
        });
    }
};
