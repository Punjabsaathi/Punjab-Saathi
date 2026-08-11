<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogComment extends Model
{
    protected $table = 'blog_comments';

    protected $fillable = [
        'blog_id', 'parent_id', 'name', 'email', 'comment', 'status', 'ip_address',
    ];

    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }

    public function parent()
    {
        return $this->belongsTo(BlogComment::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(BlogComment::class, 'parent_id')
            ->where('status', 'approved')
            ->oldest();
    }

    public function scopeApproved($q)
    {
        return $q->where('status', 'approved');
    }

    public function scopeTopLevel($q)
    {
        return $q->whereNull('parent_id');
    }
}
