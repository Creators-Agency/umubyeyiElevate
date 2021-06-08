<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('telephone')->nullable();
            $table->string('gender')->nullable();
            $table->string('location')->nullable();
            $table->date('dob')->nullable();
            $table->string('picture_url')->nullable();
            $table->integer('status')->default(1)->comment="0 for deleted, 1 for active";
            $table->integer('verified')->default(0)->comment="0 for unverified, 1 for verified";
            $table->bigInteger('verify_token');
            $table->foreignId('priviledge')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}