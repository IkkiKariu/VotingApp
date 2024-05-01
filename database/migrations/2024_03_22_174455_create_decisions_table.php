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
        Schema::create('decisions', function (Blueprint $table) {
            $table->id();
            //$table->timestamps();

            $table->bigInteger('survey_id')->unsigned();
            $table->foreign('survey_id')->references('id')->on('surveys')->onDelete('cascade');;

            $table->string('content');

            $table->integer('vote_count')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('decisions');
    }
};
