<?php

namespace App\Models;

class Topic extends Model
{
    protected $fillable = ['title', 'body', 'user_id', 'category_id', 'reply_count', 'view_count', 'last_reply_user_id', 'order', 'excerpt', 'slug'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeWithorder($query,$order)
    {
        switch ($order){
            case 'recent':
             $query = $this->recent();
            break;

            default:
                $query = $this->lastReplied();
                break;
        }
        return $query->with('user','category');
    }

    public function scopeRecent($query)
    {
        return $query->Orderby('created_at','desc');
    }

    public function scopelastReplied($query)
    {
        return $query->Orderby('updated_at','desc');
    }
}
