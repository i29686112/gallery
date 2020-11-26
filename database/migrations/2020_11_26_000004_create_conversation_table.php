<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConversationTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'TG_conversation';

    /**
     * Run the migrations.
     * @table conversation
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Unique identifier for this entry');
            $table->bigInteger('user_id')->nullable()->default(null)->comment('Unique user identifier');
            $table->bigInteger('chat_id')->nullable()->default(null)->comment('Unique user or chat identifier');
            $table->enum('status',
                ['active', 'cancelled', 'stopped'])->default('active')->comment('Conversation state');
            $table->string('command', 160)->nullable()->default('')->comment('Default command to execute');
            $table->text('notes')->nullable()->default(null)->comment('Data stored from command');

            $table->index(["status"], 'status');

            $table->index(["user_id"], 'user_id');

            $table->index(["chat_id"], 'chat_id');
            $table->nullableTimestamps();
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
