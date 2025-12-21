<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Blog extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'status',
        'published_at',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(BlogCategory::class, 'blog_blog_category');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                    ->where('published_at', '<=', now());
    }

    public function scopeActiveCategories($query)
    {
        return $query->whereHas('categories', function ($q) {
            $q->where('status', true);
        });
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($blog) {
            if (empty($blog->slug)) {
                $blog->slug = Str::slug($blog->title);
            }
            if (empty($blog->published_at) && $blog->status === 'published') {
                $blog->published_at = now();
            }
        });

        static::updating(function ($blog) {
            if ($blog->isDirty('title') && empty($blog->slug)) {
                $blog->slug = Str::slug($blog->title);
            }
            if ($blog->isDirty('status') && $blog->status === 'published' && empty($blog->published_at)) {
                $blog->published_at = now();
            }
        });
    }

    public function getSeoTitleAttribute()
    {
        return $this->meta_title ?: $this->title;
    }

    public function getSeoDescriptionAttribute()
    {
        return $this->meta_description ?: $this->excerpt;
    }

    public function getSeoKeywordsAttribute()
    {
        return $this->meta_keywords ?: '';
    }
}
