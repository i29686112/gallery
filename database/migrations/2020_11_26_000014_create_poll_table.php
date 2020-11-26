<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePollTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'TG_poll';

    /**
     * Run the migrations.
     * @table poll
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {

            $table->bigIncrements('id')->comment('Unique poll identifier');
            $table->char('question', 255)->comment('Poll question');
            $table->text('options')->comment('List of poll options');
            $table->unsignedInteger('total_voter_count')->nullable()->default(null)->comment('Total number of users that voted in the poll');
            $table->tinyInteger('is_closed')->nullable()->default('0')->comment('True, if the poll is closed');
            $table->tinyInteger('is_anonymous')->nullable()->default('1')->comment('True, if the poll is anonymous');
            $table->char('type',
                255)->nullable()->default(null)->comment('Poll type, currently can be “regular” or “quiz”');
            $table->tinyInteger('allows_multiple_answers')->nullable()->default('0')->comment('True, if the poll allows multiple answers');
            $table->unsignedInteger('correct_option_id')->nullable()->default(null)->comment('0-based identifier of the correct answer option. Available only for polls in the quiz mode, which are closed, or was sent (not forwarded) by the bot or to the private chat with the bot.');
            $table->string('explanation')->nullable()->default(null)->comment('Text that is shown when a user chooses an incorrect answer or taps on the lamp icon in a quiz-style poll, 0-200 characters');
            $table->text('explanation_entities')->nullable()->default(null)->comment('Special entities like usernames, URLs, bot commands, etc. that appear in the explanation');
            $table->unsignedInteger('open_period')->nullable()->default(null)->comment('Amount of time in seconds the poll will be active after creation');
            $table->timestamp('close_date')->nullable()->default(null)->comment('Point in time (Unix timestamp) when the poll will be automatically closed');
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
