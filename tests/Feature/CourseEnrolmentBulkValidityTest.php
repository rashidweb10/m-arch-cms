<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\CourseEnrolment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CourseEnrolmentBulkValidityTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_update_validity_for_only_the_selected_enrolments(): void
    {
        $admin = $this->createUser(1);
        $student = $this->createUser(3);
        $category = CourseCategory::create(['name' => 'Safety', 'is_active' => 1]);
        $firstCourse = Course::create(['name' => 'Navigation', 'category_id' => $category->id, 'is_active' => 1]);
        $secondCourse = Course::create(['name' => 'First Aid', 'category_id' => $category->id, 'is_active' => 1]);
        $otherCourse = Course::create(['name' => 'Security', 'category_id' => $category->id, 'is_active' => 1]);

        $firstEnrolment = CourseEnrolment::create([
            'user_id' => $student->id,
            'course_id' => $firstCourse->id,
            'validity' => now()->addDays(10)->toDateString(),
            'is_active' => 1,
        ]);
        $secondEnrolment = CourseEnrolment::create([
            'user_id' => $student->id,
            'course_id' => $secondCourse->id,
            'validity' => now()->addDays(10)->toDateString(),
            'is_active' => 1,
        ]);
        $untouchedEnrolment = CourseEnrolment::create([
            'user_id' => $student->id,
            'course_id' => $otherCourse->id,
            'validity' => now()->addDays(10)->toDateString(),
            'is_active' => 1,
        ]);

        $newValidity = now()->toDateString();

        $response = $this->actingAs($admin)->postJson(route('course-enrolments.bulk-update-validity'), [
            'ids' => $firstEnrolment->id.','.$secondEnrolment->id,
            'validity' => $newValidity,
        ]);

        $response->assertOk()->assertJsonPath('status', true);
        $this->assertDatabaseHas('course_enrolments', ['id' => $firstEnrolment->id, 'validity' => $newValidity]);
        $this->assertDatabaseHas('course_enrolments', ['id' => $secondEnrolment->id, 'validity' => $newValidity]);
        $this->assertDatabaseHas('course_enrolments', [
            'id' => $untouchedEnrolment->id,
            'validity' => now()->addDays(10)->toDateString(),
        ]);
    }

    public function test_bulk_validity_update_rejects_a_past_date(): void
    {
        $admin = $this->createUser(1);

        $response = $this->actingAs($admin)->postJson(route('course-enrolments.bulk-update-validity'), [
            'ids' => '1',
            'validity' => now()->subDay()->toDateString(),
        ]);

        $response->assertUnprocessable()->assertJsonValidationErrors('validity');
    }

    public function test_admin_can_update_selected_courses_from_the_student_page(): void
    {
        $admin = $this->createUser(1);
        $student = $this->createUser(3);
        $category = CourseCategory::create(['name' => 'Operations', 'is_active' => 1]);
        $course = Course::create(['name' => 'Bridge Operations', 'category_id' => $category->id, 'is_active' => 1]);
        $enrolment = CourseEnrolment::create([
            'user_id' => $student->id,
            'course_id' => $course->id,
            'validity' => now()->addDay()->toDateString(),
            'is_active' => 1,
        ]);

        $newValidity = now()->addMonths(6)->toDateString();
        $response = $this->actingAs($admin)->postJson(
            route('course-enrolments.student-validity.update', $student->id),
            ['enrolment_ids' => [$enrolment->id], 'validity' => $newValidity]
        );

        $response->assertOk()->assertJsonPath('status', true);
        $this->assertDatabaseHas('course_enrolments', ['id' => $enrolment->id, 'validity' => $newValidity]);
    }

    private function createUser(int $roleId): User
    {
        return User::create([
            'role_id' => $roleId,
            'name' => 'Test User '.$roleId.' '.uniqid(),
            'email' => uniqid('course-validity-', true).'@example.test',
            'password' => bcrypt('password'),
            'is_active' => 1,
        ]);
    }
}
