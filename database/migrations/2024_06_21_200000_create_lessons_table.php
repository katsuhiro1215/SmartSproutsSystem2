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
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained('stores')->comment('店舗ID');
            $table->string('name', 50)->comment('レッスン名');
            $table->text('description', 1000)->comment('レッスンの説明');
            $table->string('lesson_photo_path')->nullable()->comment('レッスンの画像パス');
            $table->boolean('status')->default(true)->comment('レッスンの状態');
            $table->date('start_date')->nullable()->comment('レッスンの開始日');
            $table->date('end_date')->nullable()->comment('レッスンの終了日');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};
