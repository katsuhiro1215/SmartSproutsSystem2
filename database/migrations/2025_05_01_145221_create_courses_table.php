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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lesson_id')->constrained('lessons')->comment('レッスンID');
            $table->foreignId('course_category_id')->constrained('course_categories')->comment('コースカテゴリーID');
            $table->string('name', 50)->comment('コース名');
            $table->text('description', 1000)->comment('コースの説明');
            $table->string('course_photo_path')->nullable()->comment('コースの画像パス');
            $table->boolean('status')->default(true)->comment('コースの状態');
            $table->date('start_date')->comment('コースの開始日');
            $table->date('end_date')->nullable()->comment('コースの終了日');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
