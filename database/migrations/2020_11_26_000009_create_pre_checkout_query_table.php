<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreCheckoutQueryTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'TG_pre_checkout_query';

    /**
     * Run the migrations.
     * @table pre_checkout_query
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {

            $table->bigIncrements('id')->comment('Unique query identifier');
            $table->bigInteger('user_id')->nullable()->default(null)->comment('User who sent the query');
            $table->char('currency', 3)->nullable()->default(null)->comment('Three-letter ISO 4217 currency code');
            $table->bigInteger('total_amount')->nullable()->default(null)->comment('Total price in the smallest units of the currency');
            $table->char('invoice_payload', 255)->default('')->comment('Bot specified invoice payload');
            $table->char('shipping_option_id',
                255)->nullable()->default(null)->comment('Identifier of the shipping option chosen by the user');
            $table->text('order_info')->nullable()->default(null)->comment('Order info provided by the user');
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
