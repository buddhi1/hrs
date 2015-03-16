<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTables extends Migration {

	public function up()
	{
		Schema::create('permissions', function($table)
		{
			$table->increments('id');
			$table->string('name');
			$table->boolean('createuser');
			$table->boolean('indexuser');
			$table->boolean('destroyuser');
			$table->boolean('edituser');
			$table->boolean('createtransaction');
			$table->boolean('createservice');
			$table->boolean('indexservice');
			$table->boolean('destroyservice');
			$table->boolean('createroom');
			$table->boolean('indexroom');
			$table->boolean('destroyroom');
			$table->boolean('editroom');
			$table->boolean('createpromotion');
			$table->boolean('indexpromotion');
			$table->boolean('destroypromotion');
			$table->boolean('editpromotion');
			$table->boolean('createpromo');
			$table->boolean('indexpromo');
			$table->boolean('destroypromo');
			$table->boolean('editpromo');
			$table->boolean('createpermission');
			$table->boolean('indexpermission');
			$table->boolean('destroypermission');
			$table->boolean('editpermission');
			$table->boolean('createfacility');
			$table->boolean('indexfacility');
			$table->boolean('destroyfacility');
			$table->boolean('createcheckin');
			$table->boolean('indexcheckin');
			$table->boolean('destroycheckin');
			$table->boolean('editcheckin');
			$table->boolean('createcalendar');
			$table->boolean('indexcalendar');
			$table->boolean('destroycalendar');
			$table->boolean('editcalendar');
			$table->timestamps();
		});

		Schema::create('users', function($table)
		{
		    $table->increments('id');
		    $table->string('name');
		    $table->string('password');
		    $table->integer('permission_id')->unsigned();
		    $table->foreign('permission_id')->references('id')->on('permissions');
		    $table->rememberToken();
		    $table->timestamps();
		});

		Schema::create('room_types', function($table)
		{
			$table->increments('id');
			$table->string('name');
			$table->text('facilities');
			$table->text('services');
			$table->integer('no_of_rooms');
			$table->timestamps();
		});

		Schema::create('facilities', function($table)
		{
			$table->increments('id');
			$table->string('name');
			$table->timestamps();
		});

		Schema::create('services', function($table)
		{
			$table->increments('id');
			$table->string('name');
			$table->timestamps();
		});

		Schema::create('room_price_calenders', function($table)
		{
			$table->increments('id');
			$table->decimal('price',8,2);
			$table->date('start_date');
			$table->date('end_date');
			$table->integer('room_type_id')->unsigned();
			$table->foreign('room_type_id')->references('id')->on('room_types');
			$table->integer('service_id')->unsigned();
			$table->foreign('service_id')->references('id')->on('services');
			$table->decimal('discount_rate',5,4);
			$table->timestamps();
		});

		Schema::create('promotion_calenders', function($table)
		{
			$table->increments('id');
			$table->decimal('price',8,2);
			$table->decimal('discount_rate',5,4);
			$table->date('start_date');
			$table->date('end_date');
			$table->integer('room_type_id')->unsigned();
			$table->foreign('room_type_id')->references('id')->on('room_types');
			$table->text('services');
			$table->integer('days');
			$table->integer('no_of_rooms');
			$table->timestamps();
		});

		Schema::create('customers',function($table){
			$table->increments('id');
			$table->integer('identification_no');
			$table->string('title');
			$table->string('first_name');
			$table->string('last_name');
			$table->string('middle_name');
			$table->string('sex');
			$table->string('country');
			$table->string('email');
			$table->string('phone_no');
			$table->string('address');
			$table->string('flight_info');
			$table->text('other');
			$table->timestamps();
		});

		Schema::create('promo_codes',function($table){
			$table->increments('id');
			$table->string('promo_code');
			$table->decimal('price', 8, 2);
			$table->date('start_date');
			$table->date('end_date');
			$table->text('services');
			$table->integer('room_type_id')->unsigned();
			$table->foreign('room_type_id')->references('id')->on('room_types');
			$table->integer('no_of_rooms');
			$table->integer('days');
			$table->timestamps();
		});

		Schema::create('bookings',function($table){
			$table->increments('id');
			$table->string('identification_no');
			$table->integer('room_type_id')->unsigned();
			$table->foreign('room_type_id')->references('id')->on('room_types');
			$table->integer('no_of_rooms');
			$table->integer('no_of_adults');
			$table->integer('no_of_kids');
			$table->text('services');
			$table->text('total_charges');
			$table->decimal('paid_amount', 8, 2);

			$table->datetime('start_date')->nullable();
			$table->datetime('end_date')->nullable();

			$table->datetime('check_in')->nullable();
			$table->datetime('check_out')->nullable();

			$table->string('promo_code');
			$table->timestamps();
		});

		Schema::create('checkins', function($table){
			$table->increments('id');
			$table->string('authorizer');

			$table->datetime('check_in')->nullable();

			$table->dateTime('check_out')->nullable();
			$table->decimal('advance_payment', 8, 2);
			$table->text('payment');
			$table->integer('booking_id')->unsigned();
			$table->foreign('booking_id')->references('id')->on('bookings');
			$table->timestamps();
		});

		Schema::create('transactions',function($table){
			$table->increments('id');
			$table->string('type');
			$table->integer('payment_id');
			$table->string('payment_gateway');
			$table->integer('booking_id')->unsigned();
			$table->foreign('booking_id')->references('id')->on('bookings');
			$table->integer('checkin_id')->unsigned();
			$table->foreign('checkin_id')->references('id')->on('checkins');
			$table->integer('customer_id')->unsigned();
			$table->foreign('customer_id')->references('id')->on('customers');
			$table->decimal('amount', 8, 2);
			$table->timestamps();
		});

		Schema::create('policies', function($table){
			$table->increments('id');
			$table->string('description');
			$table->text('variables');
			$table->timestamps();
		});

		Schema::create('taxes', function($table){
			$table->increments('id');
			$table->string('name');
			$table->decimal('rate', 8, 2);
			$table->timestamps();
		});
	}

	
	public function down()
	{
		Schema::drop('permissions');
		Schema::drop('users');
		Schema::drop('room_types');
		Schema::drop('facilities');
		Schema::drop('services');
		Schema::drop('room_price_calenders');
		Schema::drop('promotion_calenders');
		Schema::drop('customers');
		Schema::drop('promo_codes');
		Schema::drop('bookings');
		Schema::drop('checkins');
		Schema::drop('transactions');
		Schema::drop('policies');
		Schema::drop('taxes');
	}

}
