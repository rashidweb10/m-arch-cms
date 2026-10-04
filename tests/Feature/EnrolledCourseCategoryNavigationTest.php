<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\CourseEnrolment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EnrolledCourseCategoryNavigationTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_can_search_enrolled_categories_and_open_courses_in_a_category(): void
    {
        [$student, $navigationCourse, $otherCourse] = $this->createEnrolments();

        $categoriesResponse = $this->actingAs($student)
            ->get(route('auth.enrolled-categories', ['search' => 'Navigation']));

        $categoriesResponse->assertOk()
            ->assertSee('Navigation')
            ->assertDontSee('Safety');

        $coursesResponse = $this->get(route('auth.enrolled-courses', [
            'category_id' => $navigationCourse->category_id,
        ]));

        $coursesResponse->assertOk()
            ->assertSee($navigationCourse->name)
            ->assertDontSee($otherCourse->name)
            ->assertViewHas('selectedCategory', fn ($category) => $category->id === $navigationCourse->category_id);
    }

    public function test_student_cannot_filter_courses_by_a_category_they_are_not_enrolled_in(): void
    {
        [$student, , $otherCourse] = $this->createEnrolments();
        $unownedCategory = CourseCategory::create(['name' => 'Unenrolled', 'is_active' => 1]);
        $unownedCourse = Course::create([
            'name' => 'Unenrolled course',
            'category_id' => $unownedCategory->id,
            'is_active' => 1,
        ]);

        $this->actingAs($student)
            ->get(route('auth.enrolled-courses', ['category_id' => $unownedCourse->category_id]))
            ->assertNotFound()
            ->assertDontSee($otherCourse->name);
    }

    private function createEnrolments(): array
    {
        $student = User::create([
            'role_id' => 3,
            'name' => 'Category Student',
            'email' => 'category-student@example.test',
            'password' => bcrypt('password'),
            'is_active' => 1,
        ]);

        $navigation = CourseCategory::create(['name' => 'Navigation', 'is_active' => 1]);
        $safety = CourseCategory::create(['name' => 'Safety', 'is_active' => 1]);
        $navigationCourse = Course::create([
            'name' => 'Coastal Navigation',
            'category_id' => $navigation->id,
            'is_active' => 1,
        ]);
        $otherCourse = Course::create([
            'name' => 'Safety Procedures',
            'category_id' => $safety->id,
            'is_active' => 1,
        ]);

        foreach ([$navigationCourse, $otherCourse] as $course) {
            CourseEnrolment::create([
                'user_id' => $student->id,
                'course_id' => $course->id,
                'validity' => now()->addDays(30)->toDateString(),
                'is_active' => 1,
            ]);
        }

        return [$student, $navigationCourse, $otherCourse];
    }
}
