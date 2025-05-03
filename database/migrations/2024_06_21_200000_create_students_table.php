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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('lastname', 40)->comment('姓');
            $table->string('firstname', 40)->comment('名');
            $table->string('lastname_kana', 50)->comment('セイ');
            $table->string('firstname_kana', 50)->comment('メイ');
            $table->string('student_photo_path')->nullable()->comment('生徒画像');
            $table->date('birth')->comment('生年月日');
            $table->enum('gender', ['男性', '女性', 'その他'])->comment('性別');
            $table->enum('blood', ['A型', 'B型', 'O型', 'AB型', '不明', '未回答'])->comment('血液型');
            $table->string('mobile_number', 15)->comment('緊急連絡先');
            $table->string('mobile_number_relationship', 20)->comment('緊急連絡先の続柄');
            $table->text('personal_history')->comment('既往歴');
            $table->string('member_no')->nullable()->comment('会員ID');
            $table->string('membership_status', 20)->default('非会員')->comment('会員, 非会員');
            $table->string('serial_no')->nullable()->comment('シリアルナンバー');
            $table->boolean('permission_photo')->default(false)->comment('写真使用許可');
            $table->boolean('permission_dm')->default(false)->comment('DM発送許可');
            $table->text('remarks')->nullable()->comment('備考欄');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
