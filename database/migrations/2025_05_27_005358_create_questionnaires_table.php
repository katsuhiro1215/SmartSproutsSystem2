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
        Schema::create('questionnaires', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200)->comment('設問名');
            $table->text('main_description', 800)->comment('設問内容');
            // 補足
            $table->text('sub_description', 800)->nullable()->comment('設問の補足説明');
            $table->text('annotation', 600)->nullable()->comment('設問の注釈');
            $table->string('questionnaire_photo_path')->nullable()->comment('設問の画像パス');
            $table->boolean('status')->default(false)->comment('アンケートの状態');
            $table->date('start_date')->comment('公開開始日');
            $table->time('start_time')->comment('公開開始時間');
            $table->date('end_date')->comment('公開終了日');
            $table->time('end_time')->comment('公開終了時間');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questionnaires');
    }
};
