<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('intro');
            $table->text('text');
            $table->string('location');
            $table->string('streetname');
            $table->string('streetnumber');
            $table->string('postal');
            $table->string('city');
            $table->integer('member_amount');
            $table->integer('member_cost');
            $table->integer('guest_amount');
            $table->integer('guest_cost');
            $table->timestamp('started_at');
            $table->timestamp('ended_at');
            $table->timestamps();
        });
        
        Schema::create('event_mail', function(Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('text');
            $table->timestamp('sended_at');
            $table->integer('event_id')->unsigned()->index();
                $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
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
        Schema::drop('event_mail');
        Schema::drop('events');
    }
}
