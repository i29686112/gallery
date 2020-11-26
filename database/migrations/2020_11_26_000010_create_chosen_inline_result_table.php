<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChosenInlineResultTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'TG_chosen_inline_result';

    /**
     * Run the migrations.
     * @table chosen_inline_result
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {

            $table->bigIncrements('id')->comment('Unique identifier for this entry');
            $table->char('result_id',
                255)->default('')->comment('The unique identifier for the result that was chosen');
            $table->bigInteger('user_id')->nullable()->default(null)->comment('The user that chose the result');
            $table->char('location',
                255)->nullable()->default(null)->comment('Sender location, only for bots that require user location');
            $table->char('inline_message_id',
                255)->nullable()->default(null)->comment('Identifier of the sent inline message');
            $table->text('query')->comment('The query that was used to obtain the result');
            $table->timestamp('created_at')->nullable()->default(null)->comment('Entry date creation');

            $table->index(["user_id"], 'user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->tableName);
    }
}
