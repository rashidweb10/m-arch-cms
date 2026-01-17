<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'name',
        'image',
        'brochure',
        'category_id',
        'is_active',
    ];

    // Relationship: A course belongs to a category
    public function category()
    {
        return $this->belongsTo(CourseCategory::class, 'category_id');
    }

    // Relationship: A course has many materials
    public function materials()
    {
        return $this->hasMany(CourseMaterial::class);
    }
}
