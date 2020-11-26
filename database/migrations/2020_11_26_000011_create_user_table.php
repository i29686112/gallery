<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'TG_user';

    /**
     * Run the migrations.
     * @table user
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {

            $table->bigIncrements('id')->comment('Unique identifier for this user or bot');
            $table->tinyInteger('is_bot')->nullable()->default('0')->comment('True, if this user is a bot');
            $table->char('first_name', 255)->default('')->comment('User\'\'s or bot\'\'s first name');
            $table->char('last_name', 255)->nullable()->default(null)->comment('User\'\'s or bot\'\'s last name');
            $table->char('username', 191)->nullable()->default(null)->comment('User\'\'s or bot\'\'s username');
            $table->char('language_code',
                10)->nullable()->default(null)->comment('IETF language tag of the user\'\'s language');

            $table->index(["username"], 'username');
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
