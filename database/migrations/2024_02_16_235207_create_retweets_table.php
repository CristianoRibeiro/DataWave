<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRetweetsTable extends Migration
{
    public function up()
    {
        Schema::create('retweets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('tweet_id')->constrained()->onDelete('cascade');
            $table->foreignId('original_tweet_id')->constrained('tweets')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('retweets');
    }
}
