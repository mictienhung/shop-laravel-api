<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class WillRemove extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned();
            $table->string('title', 1000);
            $table->string('experience')->nullable();
            $table->string('career')->nullable();
            $table->string('employee_ranks')->nullable();
            $table->date('deadline')->nullable();
            $table->integer('salary_from')->nullable();
            $table->integer('salary_to')->nullable();
            $table->string('salary')->nullable();
            $table->string('currency')->nullable();
            $table->string('welfare')->nullable();
            $table->text('job_description')->nullable();
            $table->text('job_requirement')->nullable();
            $table->text('other_info')->nullable();
            $table->string('link', 1000)->nullable();
            $table->timestamps();
        });

        Schema::create('welfare', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('icon')->nullable();
        });

        Schema::create('employee_ranks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('rank');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('welfare');
        Schema::dropIfExists('employee_levels');
    }
}
