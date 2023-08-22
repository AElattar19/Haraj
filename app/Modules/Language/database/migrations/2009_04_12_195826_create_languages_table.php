<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('flag');
            $table->string('code');
            $table->string('local');
            $table->enum('direction', ['rtl', 'ltr'])->default('rtl');
            $table->boolean('rtl')->default(0);
            $table->tinyInteger('sort')->nullable();
            $table->integer('col')->nullable();
            $table->tinyInteger('active')->default(0)->comment('0 -> Disable , 1 -> Enable');
            $table->boolean('lock')->default(false);
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
        Schema::dropIfExists('languages');
    }
};
