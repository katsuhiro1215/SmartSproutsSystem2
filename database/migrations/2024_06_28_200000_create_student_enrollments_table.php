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
        Schema::create('student_enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->comment('生徒ID');
            $table->datetime('application_date')->comment('申込日');
            $table->datetime('enrollment_date')->comment('入会日');
            $table->string('selected_days')->nullable()->comment('希望する曜日');
            $table->string('preferred_days')->nullable()->comment('メインの曜日');
            $table->string('status', 20)->comment('ステータス')->default('承認済み');
            $table->tinyInteger('is_paid')->comment('支払い済みフラグ')->default(0);
            $table->tinyInteger('is_notified')->comment('通知済みフラグ')->default(0);
            $table->date('cancel_date')->nullable()->comment('キャンセル日');
            $table->date('suspension_start_date')->nullable()->comment('休会開始日');
            $table->date('suspension_end_date')->nullable()->comment('休会終了日');
            $table->string('suspension_reason')->nullable()->comment('休会理由');
            $table->date('withdrawal_date')->nullable()->comment('退職日');
            $table->string('withdrawal_reason')->nullable()->comment('退職理由');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_enrollments');
    }
};
