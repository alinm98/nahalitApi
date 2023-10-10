<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');

            $table->unsignedBigInteger('supervisor_id')->nullable();
            // $table->foreign('supervisor_id')->references('id')->on('supervisors')->onDelete('set null');

            $table->text('description');
            $table->integer('price');

            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');

            //$table->string('file');
            $table->boolean('confirm');
            $table->enum('status', [
                'answered',
                'waiting',
                'failed'
            ]);
            $table->integer('progress');
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
        Schema::dropIfExists('projects');
    }
};
