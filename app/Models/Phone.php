<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    use HasFactory;
    /**
     * Get the user that owns the Phone.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    /**
     * Get the comments for the blog post.
     */
    public function multiUser(){
        return $this->belongsTo(User::class);
    }
}
