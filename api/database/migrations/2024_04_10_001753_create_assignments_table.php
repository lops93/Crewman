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
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employment_id');
            $table->unsignedBigInteger('employer_id');
            $table->string('title');
            $table->timestamp('start_date');
            $table->timestamp('end_date')->nullable();;
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('employment_id')->references('id')->on('employments');
            $table->foreign('employer_id')->references('id')->on('employers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignments');
    }
};
