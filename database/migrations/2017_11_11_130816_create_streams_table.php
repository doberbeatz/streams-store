<?php

use App\Models\Stream;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStreamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Stream::TABLE_NAME, function (Blueprint $table) {
            $table->increments('id');
            $table->string('stream_id');
            $table->integer('game_id')->unsigned();
            $table->string('service');
            $table->integer('viewer_count', false, true);
            $table->timestamp('created_at', 0)->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Stream::TABLE_NAME);
    }
}
