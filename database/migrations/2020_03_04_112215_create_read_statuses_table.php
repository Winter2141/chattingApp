<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReadStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('read_statuses', function (Blueprint $table) {
            $table->id();
            $table->integer('chat_room_id');
            $table->integer('receiver_id');
            $table->integer('message_id');
            $table->integer('status')->default(0)->nullable()->comment('unread : 0 , unread : 1');
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
        Schema::dropIfExists('read_statuses');
    }
}
