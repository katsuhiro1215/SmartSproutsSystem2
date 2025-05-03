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
        Schema::create('admin_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->constrained('admins')->comment('管理者ID');
            $table->string('lastname', 40)->comment('姓');
            $table->string('firstname', 40)->comment('名');
            $table->string('lastname_kana', 50)->comment('セイ');
            $table->string('firstname_kana', 50)->comment('メイ');
            $table->string('admin_photo_path')->nullable()->comment('管理者画像パス');
            $table->string('birth')->comment('生年月日');
            $table->enum('gender', ['男性', '女性', 'その他'])->comment('性別');
            $table->enum('blood', ['A型', 'B型', 'O型', 'AB型', '不明', '未回答'])->comment('血液型');
            $table->string('mobile_number', 15)->comment('携帯番号');
            $table->string('admin_no', 20)->comment('管理者番号');
            $table->string('serial_no', 20)->nullable()->comment('シリアル番号');
            $table->string('website')->nullable()->comment('Webサイト URL');
            $table->string('facebook')->nullable()->comment('Facebook URL');
            $table->string('twitter')->nullable()->comment('Twitter URL');
            $table->string('instagram')->nullable()->comment('Instagram URL');
            $table->string('youtube')->nullable()->comment('YouTube URL');
            $table->string('line')->nullable()->comment('LINE ID');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_profiles');
    }
};
