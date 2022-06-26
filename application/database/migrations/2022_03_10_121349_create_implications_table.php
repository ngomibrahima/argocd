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
        Schema::create('implications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cadeau_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->string('structure');
            $table->string('prenom')->nullable();
            $table->string('nom')->nullable();

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
        Schema::dropIfExists('implications');
    }
};
