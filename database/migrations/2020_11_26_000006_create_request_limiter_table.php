<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestLimiterTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'TG_request_limiter';

    /**
     * Run the migrations.
     * @table request_limiter
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {

            $table->bigIncrements('id')->comment('Unique identifier for this entry');
            $table->char('chat_id', 255)->nullable()->default(null)->comment('Unique chat identifier');
            $table->char('inline_message_id',
                255)->nullable()->default(null)->comment('Identifier of the sent inline message');
            $table->char('method', 255)->nullable()->default(null)->comment('Request method');
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
