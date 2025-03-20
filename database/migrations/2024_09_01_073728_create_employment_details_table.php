<?php

use App\Classes\PrintableTable;
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
        Schema::create('employment_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('position_id');
            $table->string('department');
            $table->unsignedBigInteger('manager_id')->nullable();
            $table->unsignedBigInteger('supervisor_id')->nullable();
            $table->string('employment_status');
            $table->date('date_hired');
            $table->date('date_regularized');
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
        Schema::dropIfExists('employment_details');
    }
};
