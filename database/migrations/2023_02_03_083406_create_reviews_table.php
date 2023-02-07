<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Resto;


return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->text('text', 750);
            $table->unsignedInteger('rating')->default(0);
            $table->timestamps();
            $table->foreignIdFor(User::class, 'user_id')->cascadeOnDelate();
            $table->foreignIdFor(Resto::class, 'resto_id')->cascadeOnDelate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reviews');
    }
};
