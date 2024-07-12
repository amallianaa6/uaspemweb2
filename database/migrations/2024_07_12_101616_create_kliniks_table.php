<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKliniksTable extends Migration
{
    public function up()
    {
        Schema::create('kliniks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->float('harga');
            $table->float('jarak');
            $table->float('layanan');
            $table->float('testimoni');
            $table->float('teknologi');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kliniks');
    }
};

