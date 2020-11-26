<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShippingQueryTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'TG_shipping_query';

    /**
     * Run the migrations.
     * @table shipping_query
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Unique query identifier');
            $table->bigInteger('user_id')->nullable()->default(null)->comment('User who sent the query');
            $table->char('invoice_payload', 255)->default('')->comment('Bot specified invoice payload');
            $table->char('shipping_address', 255)->default('')->comment('User specified shipping address');
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
