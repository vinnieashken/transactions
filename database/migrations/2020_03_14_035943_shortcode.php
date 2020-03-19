<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Shortcode extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
            {
                Schema::create('shortcodes',function (Blueprint $table){
                    $table->id();
                    $table->string('shortcode');
                    $table->integer('status');
                    $table->integer('user_id')->unsigned();
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
                Schema::dropIfExists('shortcodes');
            }
    }
