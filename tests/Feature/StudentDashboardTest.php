<?php

namespace Tests\Feature;

use App\Models\Certificate;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\CourseEnrolment;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_dashboard_counts_active_categories_and_hides_removed_sections(): void
    {
        $student = User::create([
            'role_id' => 3,
            'name' => 'Student Example',
            'email' => 'student@example.test',
            'password' => bcrypt('password'),
            'is_active' => 1,
        ]);

        $category = CourseCategory::create(['name' => 'Navigation', 'is_active' => 1]);
        $otherCategory = CourseCategory::create(['name' => 'Safety', 'is_active' => 1]);
        $activeCourse = Course::create([
            'name' => 'Bridge Resource Management',
            'category_id' => $category->id,
            'is_active' => 1,
        ]);
        $secondActiveCourse = Course::create([
            'name' => 'Coastal Navigation',
            'category_id' => $category->id,
            'is_active' => 1,
        ]);
        $thirdActiveCourse = Course::create([
            'name' => 'Emergency Procedures',
            'category_id' => $otherCategory->id,
            'is_active' => 1,
        ]);
        $expiredCourse = Course::create([
            'name' => 'Expired Course',
            'category_id' => $category->id,
            'is_active' => 1,
        ]);
        $inactiveCourse = Course::create([
            'name' => 'Inactive Course',
            'category_id' => $category->id,
            'is_active' => 1,
        ]);

        CourseEnrolment::create([
            'user_id' => $student->id,
            'course_id' => $activeCourse->id,
            'validity' => now()->addDays(30)->toDateString(),
            'is_active' => 1,
        ]);
        CourseEnrolment::create([
            'user_id' => $student->id,
            'course_id' => $secondActiveCourse->id,
            'validity' => now()->addDays(30)->toDateString(),
            'is_active' => 1,
        ]);
        CourseEnrolment::create([
            'user_id' => $student->id,
            'course_id' => $thirdActiveCourse->id,
            'validity' => now()->addDays(30)->toDateString(),
            'is_active' => 1,
        ]);
        CourseEnrolment::create([
            'user_id' => $student->id,
            'course_id' => $expiredCourse->id,
            'validity' => now()->subDay()->toDateString(),
            'is_active' => 1,
        ]);
        CourseEnrolment::create([
            'user_id' => $student->id,
            'course_id' => $inactiveCourse->id,
            'validity' => null,
            'is_active' => 0,
        ]);

        $quiz = Quiz::create([
            'course_id' => $activeCourse->id,
            'title' => 'Course assessment',
            'total_marks' => 10,
            'pass_marks' => 7,
            'is_active' => 1,
        ]);

        Certificate::create([
            'user_id' => $student->id,
            'course_id' => $activeCourse->id,
            'quiz_id' => $quiz->id,
            'certificate_no' => 'CERT-STUDENT-TEST',
            'issued_at' => now(),
        ]);

        $response = $this->actingAs($student)->get(route('auth.dashboard'));

        $response->assertOk()
            ->assertSee('Welcome, Student Example')
            ->assertSee('Active courses')
            ->assertSee('Certificates earned')
            ->assertDontSee('Learning resources')
            ->assertDontSee('Continue learning')
            ->assertDontSee('Bridge Resource Management')
            ->assertDontSee('Expired Course')
            ->assertDontSee('Inactive Course');

        $response->assertViewHas('activeCategoryCount', 2);
    }
}
