<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'TG_chat';

    /**
     * Run the migrations.
     * @table chat
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {

            $table->bigIncrements('id')->comment('Unique identifier for this chat');
            $table->enum('type', [
                'private',
                'group',
                'supergroup',
                'channel',
            ])->comment('Type of chat, can be either private, group, supergroup or channel');
            $table->char('title',
                255)->nullable()->default('')->comment('Title, for supergroups, channels and group chats');
            $table->char('username',
                255)->nullable()->default(null)->comment('Username, for private chats, supergroups and channels if available');
            $table->char('first_name',
                255)->nullable()->default(null)->comment('First name of the other party in a private chat');
            $table->char('last_name',
                255)->nullable()->default(null)->comment('Last name of the other party in a private chat');
            $table->tinyInteger('all_members_are_administrators')->nullable()->default('0')->comment('True if a all members of this group are admins');
            $table->bigInteger('old_id')->nullable()->default(null)->comment('Unique chat identifier, this is filled when a group is converted to a supergroup');

            $table->index(["old_id"], 'old_id');
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
