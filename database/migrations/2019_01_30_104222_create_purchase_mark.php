<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseMark extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product',function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',30);
            $table->text('cover')->nullable()->comment('商品图片');

        });

        Schema::create('product_mark',function (Blueprint $table) {
           $table->increments('id')->comment('唛头标签表');
           $table->string('name',30);
           $table->text('img')->nullable();
           $table->text('note')->nullable();
        });


        Schema::create('product_mark_link',function (Blueprint $table) {
            $table->integer('mark_id')->comment('mark 表的id');
            $table->tinyInteger('type')->comment('关联类型');
            $table->integer('id')->comment('mark关联其他表的id');

            $table->index('mark_id');
            $table->index('type');
            $table->index('id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_mark');
        Schema::dropIfExists('product_mark_link');
    }
}
