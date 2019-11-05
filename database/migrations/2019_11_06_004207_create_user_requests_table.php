<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('request_number');
            $table->string('description')->nullable();
            $table->dateTime('borrow_date');
            $table->dateTime('return_date');

            //status_id
            $table->unsignedBigInteger('status_id')->default(1);
            $table->foreign('status_id')
                ->references('id')
                ->on('statuses')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            //user_id
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            //category_id
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            //asset_id
            $table->unsignedBigInteger('asset_id')->nullable();
            $table->foreign('asset_id')
                ->references('id')
                ->on('assets')
                ->onDelete('restrict')
                ->onUpdate('cascade');


            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_requests');
    }
}
