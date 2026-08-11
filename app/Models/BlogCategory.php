<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BlogCategory extends Model
{
    protected $fillable = ['name', 'slug', 'description'];

    protected static function booted(): void
    {
        static::creating(fn ($cat) => $cat->slug ??= Str::slug($cat->name));
    }

    public function blogs()
    {
        return $this->hasMany(Blog::class, 'category_id');
    }
}
