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
        Schema::create('recruitments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->date('birthday');
            $table->boolean('martial_status');
            $table->string('address');
            $table->string('activity');
            $table->string('eduction_status');
            $table->string('ability_description')->nullable();
            $table->string('shaba_number');
            $table->string('status'); //'waiting', 'rejected', 'accepted'
            $table->string('card_number')->nullable()->unique();
            $table->string('code_melli')->nullable()->unique();

            $table->unsignedBigInteger('mentor_id')->nullable();

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
        Schema::dropIfExists('recruitments');
    }
};
