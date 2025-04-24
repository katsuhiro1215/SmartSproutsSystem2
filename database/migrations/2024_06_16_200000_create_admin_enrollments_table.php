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
        Schema::create('admin_enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->constrained('admins')->comment('管理者ID');
            $table->date('enrollment_date')->comment('入社日');
            $table->date('start_date')->comment('利用開始日');
            $table->tinyInteger('is_notified')->comment('通知済みフラグ')->default(0);
            $table->date('suspension_start_date')->nullable()->comment('休職開始日');
            $table->date('suspension_end_date')->nullable()->comment('休職終了日');
            $table->string('suspension_reason')->nullable()->comment('休職理由');
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
        Schema::dropIfExists('admin_enrollments');
    }
};
