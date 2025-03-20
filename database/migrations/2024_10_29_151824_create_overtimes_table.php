<?php

use App\Enums\StatusEnum;
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
        Schema::create('overtimes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('entry_id');
            $table->unsignedBigInteger('user_id');
            $table->dateTime('time_start');
            $table->dateTime('time_end');
            $table->text('purpose');
            $table->text('comment')->nullable();
            $table->enum('status', [StatusEnum::PENDING->value, StatusEnum::APPROVED->value, StatusEnum::REJECTED->value, StatusEnum::CANCELLED->value])->default(StatusEnum::PENDING->value);
            $table->boolean('is_sp_approved')->nullable();
            $table->boolean('is_mng_approved')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('entry_id')->references('id')->on('entries')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('overtimes');
    }
};
