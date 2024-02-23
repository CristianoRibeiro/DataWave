<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHashtagTweetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hashtag_tweet', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hashtag_id');
            $table->unsignedBigInteger('tweet_id');
            $table->timestamps();

            $table->foreign('hashtag_id')->references('id')->on('hashtags')->onDelete('cascade');
            $table->foreign('tweet_id')->references('id')->on('tweets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hashtag_tweet');
    }
}
