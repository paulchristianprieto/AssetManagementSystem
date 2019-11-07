<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('image');
            $table->string('description');
            $table->string('sku_number')->unique();
            $table->boolean('available');
            $table->unsignedInteger('quantity_available');

            //category_id
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('set null')
                ->onUpdate('cascade');

            //vendor_id
            $table->unsignedBigInteger('vendor_id')->nullable();
            $table->foreign('vendor_id')
                ->references('id')
                ->on('vendors')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            //asset_status_id
            $table->unsignedBigInteger('asset_status_id')->default(1);
            $table->foreign('asset_status_id')
                ->references('id')
                ->on('asset_statuses')
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
        Schema::dropIfExists('assets');
    }
}
