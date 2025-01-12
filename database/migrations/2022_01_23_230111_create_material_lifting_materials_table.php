<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialLiftingMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_lifting_materials', function (Blueprint $table) {
            $table->id();
            $table->integer('material_lifting_id');
            $table->integer('material_id');
            $table->integer('unit_id');
            $table->integer('material_qty');
            $table->integer('material_rate');
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
        Schema::dropIfExists('material_lifting_materials');
    }
}
