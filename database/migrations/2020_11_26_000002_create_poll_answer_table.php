<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePollAnswerTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'TG_poll_answer';

    /**
     * Run the migrations.
     * @table poll_answer
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->bigIncrements('poll_id')->comment('Unique poll identifier');
            $table->bigInteger('user_id')->comment('The user, who changed the answer to the poll');
            $table->text('option_ids')->comment('0-based identifiers of answer options, chosen by the user. May be empty if the user retracted their vote.');
            $table->timestamp('created_at')->nullable()->default(null)->comment('Entry date creation');
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
