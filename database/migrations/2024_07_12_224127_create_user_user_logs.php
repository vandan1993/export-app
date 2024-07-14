<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_details', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id',false,true)->unique();
            $table->string('email')->unique();
            $table->string('name');
            $table->string('password');
            $table->string('status');
            $table->timestamp('user_created_at');
            $table->timestamp('user_updated_at');
            $table->timestamps();
        });


        Schema::create('user_details_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id',false,true);
            $table->string('action_performed');
            $table->string('status');
            $table->timestamp('user_logs_created_at');
            $table->timestamp('user_logs_updated_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_details');

        Schema::dropIfExists('user_user_logs');
    }
};
