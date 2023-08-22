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
        Schema::create('areas', function (Blueprint $table) {

            $table->id();
            $table->json('title');
            $table->json('description')->nullable();
            $table->boolean('active')->default(true);
            $table->foreignId('parent_id')->nullable()->constrained('areas')->cascadeOnDelete();
            $table->integer('level')->nullable();
            $table->double('latitude')->nullable();
            $table->double('longitude')->nullable();
            $table->double('radius')->nullable();
            $table->text('address')->nullable();
            $table->string('slug')->nullable()->unique();
            $table->timestamps();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
        });
    }
     /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('areas');
    }
};
