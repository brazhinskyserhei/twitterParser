<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TwitterUser extends Model
{
    protected $table = 'twitter_users';
    protected $fillable = [
							'photo','name',
						    'twitter_id',
							'description',
							'tweets', 
							'following',
							'followers',
							'likes'
						  ];
    public function getPhotoAttribute($image)
    {
        return env('APP_URL').'/storage/img/' . $image;
    }
}
