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
        Schema::table('cadeaus', function (Blueprint $table) {
            $table->text('motif_accept_rejet')->nullable();
            $table->integer('admin_modif_statut')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cadeaus', function (Blueprint $table) {
            $table->dropColumn('motif_accept_rejet');
            $table->dropColumn('admin_modif_statut');
        });
    }
};
