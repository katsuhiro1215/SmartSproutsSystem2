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
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained('organizations')->comment('組織ID');
            $table->string('name', 50)->comment('店舗名');
            $table->string('type', 20)->comment('店舗の種類');
            $table->string('code', 20)->unique()->comment('店舗コード');
            $table->string('theme_color', 7)->default('#000000')->comment('テーマカラー');
            $table->text('description', 1000)->comment('店舗の説明');
            $table->string('email')->unique()->comment('店舗のメールアドレス');
            $table->string('store_photo_path')->nullable()->comment('店舗の画像パス');
            $table->string('store_logo_path')->nullable()->comment('店舗のロゴパス');
            $table->string('postalcode', 7)->comment('郵便番号');
            $table->string('prefecture', 10)->comment('都道府県');
            $table->string('city', 30)->comment('市区町村名');
            $table->string('address1', 50)->comment('町名・番地');
            $table->string('address2', 100)->comment('建物名など');
            $table->string('phone_number', 15)->comment('電話番号');
            $table->string('fax_number', 15)->nullable()->comment('FAX番号');
            $table->boolean('status')->default(true)->comment('店舗の状態');
            $table->date('established_date')->comment('設立日');
            $table->string('website')->nullable()->comment('WebサイトURL');
            $table->string('facebook')->nullable()->comment('Facebook URL');
            $table->string('twitter')->nullable()->comment('Twitter URL');
            $table->string('instagram')->nullable()->comment('Instagram URL');
            $table->string('youtube')->nullable()->comment('YouTube URL');
            $table->string('line')->nullable()->comment('LINE URL');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};
