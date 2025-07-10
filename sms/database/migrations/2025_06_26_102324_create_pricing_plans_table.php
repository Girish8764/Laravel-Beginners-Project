<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePricingPlansTable extends Migration
{
    public function up()
    {
        Schema::create('pricing_plans', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->decimal('price', 10, 2);
            $table->string('duration');
            $table->json('features');
            $table->boolean('is_featured')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pricing_plans');
    }
}