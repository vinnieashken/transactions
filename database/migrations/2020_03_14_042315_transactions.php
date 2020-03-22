<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Transactions extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
            {
                Schema::create('transactions',function(Blueprint $table){
                    $table->id();
                    $table->string('transaction_code');
                    $table->string('mpesa_code');
                    $table->integer('service_id')->unsigned();
                    $table->string('msisdn');
                    $table->integer('has_notified')->default(0);
                    $table->timestamp('transaction_time');
                    $table->decimal('amount',8,2);
                    $table->timestamps();
                });

            }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down()
            {
                Schema::dropIfExists('transactions');
            }
    }
