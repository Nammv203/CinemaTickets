<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ticket_order_items', function(Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('ticket_order_id');
            $table->unsignedBigInteger('cinema_room_chair_id');
            $table->integer('chair_type');
            $table->string('chair_code');
            $table->integer('chair_type_price');
            $table->integer('ticket_item_price')->default(0);
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
		Schema::drop('ticket_order_items');
	}
};
