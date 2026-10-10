<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\CourseEnrolment;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BulkCourseAssignmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_open_the_separate_bulk_assignment_form(): void
    {
        Role::create(['name' => 'Administrator']);
        $admin = $this->createUser(1);
        $student = $this->createUser(3);
        $category = CourseCategory::create(['name' => 'Safety', 'is_active' => 1]);

        $response = $this->actingAs($admin)->get(route('course-enrolments.bulk-assign'));

        $response->assertOk()
            ->assertSee('Bulk Assign Courses')
            ->assertSee($student->name)
            ->assertSee($category->name);
    }

    public function test_admin_can_replace_selected_course_assignments_for_multiple_students(): void
    {
        $admin = $this->createUser(1);
        $firstStudent = $this->createUser(3);
        $secondStudent = $this->createUser(3);
        $otherStudent = $this->createUser(3);
        $category = CourseCategory::create(['name' => 'Safety', 'is_active' => 1]);
        $firstCourse = Course::create(['name' => 'Navigation', 'category_id' => $category->id, 'is_active' => 1]);
        $secondCourse = Course::create(['name' => 'First Aid', 'category_id' => $category->id, 'is_active' => 1]);
        $untouchedCourse = Course::create(['name' => 'Security', 'category_id' => $category->id, 'is_active' => 1]);

        CourseEnrolment::create([
            'user_id' => $firstStudent->id,
            'course_id' => $firstCourse->id,
            'validity' => '2026-01-01',
            'is_active' => 1,
        ]);
        CourseEnrolment::create([
            'user_id' => $firstStudent->id,
            'course_id' => $untouchedCourse->id,
            'validity' => '2026-01-01',
            'is_active' => 1,
        ]);
        CourseEnrolment::create([
            'user_id' => $secondStudent->id,
            'course_id' => $secondCourse->id,
            'validity' => '2026-01-01',
            'is_active' => 1,
        ]);
        CourseEnrolment::create([
            'user_id' => $otherStudent->id,
            'course_id' => $firstCourse->id,
            'validity' => '2026-01-01',
            'is_active' => 1,
        ]);

        $response = $this->actingAs($admin)->post(route('course-enrolments.bulk-assign.store'), [
            'student_ids' => [$firstStudent->id, $secondStudent->id],
            'category_id' => $category->id,
            'course_ids' => [$firstCourse->id, $secondCourse->id],
            'validity' => '2027-01-01',
            'is_active' => 0,
        ]);

        $response->assertRedirect(route('course-enrolments.bulk-assign'))
            ->assertSessionHas('status', '4 course assignment(s) saved successfully.');

        foreach ([$firstStudent, $secondStudent] as $student) {
            foreach ([$firstCourse, $secondCourse] as $course) {
                $this->assertDatabaseHas('course_enrolments', [
                    'user_id' => $student->id,
                    'course_id' => $course->id,
                    'validity' => '2027-01-01',
                    'is_active' => 0,
                ]);
            }
        }

        $this->assertDatabaseHas('course_enrolments', [
            'user_id' => $firstStudent->id,
            'course_id' => $untouchedCourse->id,
            'validity' => '2026-01-01',
            'is_active' => 1,
        ]);
        $this->assertDatabaseHas('course_enrolments', [
            'user_id' => $otherStudent->id,
            'course_id' => $firstCourse->id,
            'validity' => '2026-01-01',
            'is_active' => 1,
        ]);
        $this->assertSame(6, CourseEnrolment::count());
    }

    public function test_bulk_assignment_rejects_courses_outside_the_selected_category(): void
    {
        $admin = $this->createUser(1);
        $student = $this->createUser(3);
        $category = CourseCategory::create(['name' => 'Safety', 'is_active' => 1]);
        $otherCategory = CourseCategory::create(['name' => 'Operations', 'is_active' => 1]);
        $course = Course::create(['name' => 'Navigation', 'category_id' => $otherCategory->id, 'is_active' => 1]);

        $response = $this->actingAs($admin)->from(route('course-enrolments.bulk-assign'))
            ->post(route('course-enrolments.bulk-assign.store'), [
                'student_ids' => [$student->id],
                'category_id' => $category->id,
                'course_ids' => [$course->id],
                'validity' => '2027-01-01',
                'is_active' => 1,
            ]);

        $response->assertRedirect(route('course-enrolments.bulk-assign'))
            ->assertSessionHasErrors('course_ids');
        $this->assertDatabaseMissing('course_enrolments', [
            'user_id' => $student->id,
            'course_id' => $course->id,
        ]);
    }

    public function test_bulk_assignment_only_accepts_student_accounts(): void
    {
        $admin = $this->createUser(1);
        $nonStudent = $this->createUser(2);
        $category = CourseCategory::create(['name' => 'Safety', 'is_active' => 1]);
        $course = Course::create(['name' => 'Navigation', 'category_id' => $category->id, 'is_active' => 1]);

        $response = $this->actingAs($admin)->from(route('course-enrolments.bulk-assign'))
            ->post(route('course-enrolments.bulk-assign.store'), [
                'student_ids' => [$nonStudent->id],
                'category_id' => $category->id,
                'course_ids' => [$course->id],
                'is_active' => 1,
            ]);

        $response->assertRedirect(route('course-enrolments.bulk-assign'))
            ->assertSessionHasErrors('student_ids');
        $this->assertDatabaseMissing('course_enrolments', [
            'user_id' => $nonStudent->id,
            'course_id' => $course->id,
        ]);
    }

    private function createUser(int $roleId): User
    {
        return User::create([
            'role_id' => $roleId,
            'name' => 'Test User '.$roleId.' '.uniqid(),
            'email' => uniqid('bulk-course-', true).'@example.test',
            'password' => bcrypt('password'),
            'is_active' => 1,
        ]);
    }
}
