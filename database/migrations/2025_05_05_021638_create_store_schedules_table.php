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
        Schema::create('store_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained('stores');
            $table->date('business_date')->comment('営業日');
            $table->time('start_time')->nullable()->comment('営業開始時間');
            $table->time('end_time')->nullable()->comment('営業終了時間');
            $table->enum('day_of_week', ['月曜日', '火曜日', '水曜日', '木曜日', '金曜日', '土曜日', '日曜日'])->comment('曜日');
            $table->boolean('status')->default(true)->comment('スケジュールの状態');
            $table->string('note')->nullable()->comment('備考');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_schedules');
    }
};
