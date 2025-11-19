<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseMaterial extends Model
{
    protected $fillable = [
        'course_id',
        'title',
        'description',
        'attachments',
        'is_active',
    ];

    // Relationship: Each material belongs to a course
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}
