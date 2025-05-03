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
        Schema::create('guardians', function (Blueprint $table) {
            $table->id();
            $table->string('lastname', 40)->comment('姓');
            $table->string('firstname', 40)->comment('名');
            $table->string('lastname_kana', 50)->comment('セイ');
            $table->string('firstname_kana', 50)->comment('メイ');
            $table->string('relationship', 20)->comment('続柄');
            $table->string('guardian_photo_path')->nullable()->comment('保護者画像');
            $table->date('birth')->nullable()->comment('生年月日');
            $table->enum('gender', ['男性', '女性', 'その他'])->comment('性別');
            $table->enum('blood', ['A型', 'B型', 'O型', 'AB型', '不明', '未回答'])->comment('血液型');
            $table->string('mobile_number', 15)->comment('携帯電話番号');
            $table->string('company_name', 50)->nullable()->comment('勤務先');
            $table->string('company_phone_number', 20)->nullable()->comment('勤務先電話番号');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guardians');
    }
};
