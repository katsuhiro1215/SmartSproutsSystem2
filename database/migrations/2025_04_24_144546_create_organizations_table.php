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
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['個人', '法人'])->comment('組織の種類');
            $table->string('name', 50)->comment('組織名');
            $table->text('description', 1000)->comment('組織の説明');
            $table->string('email')->unique()->comment('組織のメールアドレス');
            $table->string('organization_photo_path')->nullable()->comment('組織の画像パス');
            $table->string('organization_logo_path')->nullable()->comment('組織のロゴパス');
            $table->string('postalcode', 7)->comment('郵便番号');
            $table->string('prefecture', 10)->comment('都道府県');
            $table->string('city', 30)->comment('市区町村名');
            $table->string('address1', 50)->comment('町名・番地');
            $table->string('address2', 100)->comment('建物名など');
            $table->string('phone_number', 15)->comment('電話番号');
            $table->string('fax_number', 15)->nullable()->comment('FAX番号');
            $table->boolean('status')->default(true)->comment('組織の状態');
            $table->date('established_date')->nullable()->comment('設立日');
            $table->string('website')->nullable()->comment('WebサイトURL');
            $table->string('facebook')->nullable()->comment('Facebook URL');
            $table->string('twitter')->nullable()->comment('Twitter URL');
            $table->string('instagram')->nullable()->comment('Instagram URL');
            $table->string('youtube')->nullable()->comment('YouTube URL');
            $table->string('line')->nullable()->comment('LINE URL');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organizations');
    }
};
