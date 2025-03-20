<?php

use App\Classes\PrintableTable;
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
        Schema::create('leaves', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('leave_type_id');
            $table->date('date');
            $table->string('type');
            $table->decimal('total_credit');
            $table->string('is_mgr_approval_status')->default(StatusEnum::PENDING);
            $table->string('is_sp_approval_status')->default(StatusEnum::PENDING);
            $table->text('reason');
            $table->text('remarks')->nullable();
            $table->string('status')->default(StatusEnum::PENDING);
            (new PrintableTable($table))->modifier($table);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leaves');
    }
};
