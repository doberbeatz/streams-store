<?php

use App\Models\Game;
use App\Models\Stream;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyToGameId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(Stream::TABLE_NAME, function (Blueprint $table) {
            $table->foreign('game_id')
                ->references('id')->on(Game::TABLE_NAME)
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(Stream::TABLE_NAME, function (Blueprint $table) {
            $table->dropForeign('streams_game_id_foreign');
        });
    }
}
