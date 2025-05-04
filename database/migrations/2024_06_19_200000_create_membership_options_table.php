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
        Schema::create('membership_options', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->comment('オプション名');
            $table->string('description')->comment('オプション説明');
            $table->boolean('status')->default(true)->comment('ステータス');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('membership_options');
    }
};
