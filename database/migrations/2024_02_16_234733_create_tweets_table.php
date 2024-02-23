<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTweetsTable extends Migration
{
    public function up()
    {
        Schema::create('tweets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('content');
            $table->string('media')->nullable(); // Campo de mídia
            $table->enum('type', ['original', 'retweet'])->default('original'); // Campo de tipo
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tweets');
    }
}
