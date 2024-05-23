<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialLiftingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_liftings', function (Blueprint $table) {
            $table->id();
            $table->integer('company_id');
            $table->text('system_serial');
            $table->integer('vendor_id');
            $table->text('voucher');
            $table->text('vouchar_date');
            $table->integer('client_provided')->default(0);
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
        Schema::dropIfExists('material_liftings');
    }
}
