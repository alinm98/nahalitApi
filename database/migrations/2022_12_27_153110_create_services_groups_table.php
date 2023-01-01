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
        Schema::create('services_groups', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->foreignId('services_group_id')->nullable()->constrained();
            $table->integer('first_value');
            $table->integer('second_value')->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('services_groups');
    }
};
