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
        Schema::create('reservations', function (Blueprint $table) {

            $table->uuid('reservation_id');
            $table->string('user_id');
            $table->string('staff_id');
            $table->string('service_master_id');

            $table->dateTime('start_date_time');
            $table->dateTime('end_date_time');
            $table->boolean('is_booked')->default(false);
            
            # pk
            $table->primary(['reservation_id', 'user_id']);

            # デフォルト
            $table->timestamps(); 
            $table->boolean("is_deleted")->default(false);
        
            // 外部キー制約を追加（必要に応じて）
            // $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
