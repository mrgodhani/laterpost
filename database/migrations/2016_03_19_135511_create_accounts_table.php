<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('token');
            $table->string('secret')->nullable()->default(NULL);
            $table->string('provider')->default('twitter');
            $table->string('username')->nullable()->default(NULL);
            $table->string('avatar')->nullable()->default(NULL);
            $table->string('profile_id')->nullable()->default(NULL);
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
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
        Schema::drop('accounts');
    }
}
