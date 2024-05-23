<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectWiseBudgetItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_wise_budget_items', function (Blueprint $table) {
            $table->id();
            $table->integer('projectwise_budget_id');
            $table->text('budget_head'); // add budget type in a dropdown and on change show type wise budgets
            $table->decimal('amount'); // always
            $table->decimal('qty'); // in case of cash material
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
        Schema::dropIfExists('project_wise_budget_items');
    }
}
