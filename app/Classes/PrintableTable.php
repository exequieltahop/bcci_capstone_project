<?php

namespace App\Classes;

use Illuminate\Database\Schema\Blueprint;

class PrintableTable {

    public function modifier(Blueprint $table) {
        $table->unsignedBigInteger('created_by')->nullable();

        $table->unsignedBigInteger('updated_by')->nullable();

        $table->unsignedBigInteger('deleted_by')->nullable();
    }
}
