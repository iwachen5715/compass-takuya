<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    const UPDATED_AT = null;
    const CREATED_AT = null;

    protected $fillable = [
        'user_id',
        'post_title',
        'post',
    ];
//いいね数表示





    public function user()
    {
        return $this->belongsTo('App\Models\Users\User');
    }

    public function likes()
    {
        return $this->hasMany(Like::class, 'like_post_id', 'id');
    }

    public function postComments(){

        return $this->hasMany('App\Models\Posts\PostComment', 'post_id', 'id');
    }

    public function subCategories(){
        // リレーションの定義
    }

    // コメント数
    public function commentCounts($post_id){
        return Post::with('postComments')->find($post_id)->postComments();
    }

    public function likeCounts()
    {
        return $this->likes()->count();
    }
}
