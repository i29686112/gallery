<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInlineQueryTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'TG_inline_query';

    /**
     * Run the migrations.
     * @table inline_query
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {

            $table->bigIncrements('id')->comment('Unique identifier for this query');
            $table->bigInteger('user_id')->nullable()->default(null)->comment('Unique user identifier');
            $table->char('location', 255)->nullable()->default(null)->comment('Location of the user');
            $table->text('query')->comment('Text of the query');
            $table->char('offset', 255)->nullable()->default(null)->comment('Offset of the result');
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
