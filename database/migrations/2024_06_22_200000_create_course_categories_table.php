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
        Schema::create('course_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lesson_id')->constrained('lessons');
            $table->enum('type', ['一般教室', '体験教室', '短期教室'])->comment('コースカテゴリーの種類');
            $table->string('name', 50)->comment('コースカテゴリー名');
            $table->text('description', 1000)->comment('コースカテゴリーの説明');
            $table->string('course_category_photo_path')->nullable()->comment('コースカテゴリーの画像パス');
            $table->boolean('status')->default(true)->comment('コースカテゴリーの状態');
            $table->date('start_date')->comment('コースカテゴリーの開始日');
            $table->date('end_date')->nullable()->comment('コースカテゴリーの終了日');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_categories');
    }
};
