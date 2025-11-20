<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    // Common Excel reader function
    private function readExcel($filename)
    {
        $path = public_path("import/" . $filename);

        if (!file_exists($path)) {
            return ['status' => false, 'message' => "$filename not found in public/import"];
        }

        $data = Excel::toArray([], $path);
        return ['status' => true, 'rows' => $data[0]];
    }

    // -----------------------------------------
    // 1) COURSE CATEGORIES IMPORT
    // -----------------------------------------
    public function importCourseCategories()
    {
        $data = $this->readExcel("tblcoursecategories.csv");
        if (!$data['status']) return $data;

        $rows = $data['rows'];
        $insert = [];

        array_shift($rows); // removes first row

        foreach ($rows as $r) {

            if (!isset($r[0])) continue;

            $insert[] = [
                'id'         => $r[0],
                'name'       => $r[2],
                'image'      => null,
                'is_active'  => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        foreach (array_chunk($insert, 100) as $chunk) {
            DB::table('course_categories')->insertOrIgnore($chunk);
        }

        return "Course Categories Imported Successfully";
    }

    // -----------------------------------------
    // 2) COURSES IMPORT
    // -----------------------------------------
    public function importCourses()
    {
        $data = $this->readExcel("courses.xlsx");
        if (!$data['status']) return $data;

        $rows = $data['rows'];
        $insert = [];

        foreach ($rows as $r) {
            if (!isset($r[0])) continue;

            $insert[] = [
                'id'         => $r[0],
                'name'       => $r[1] ?? null,
                'image'      => $r[2] ?? null,
                'category_id'=> $r[3] ?? null,
                'is_active'  => $r[4] ?? 1,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        foreach (array_chunk($insert, 500) as $chunk) {
            DB::table('courses')->insertOrIgnore($chunk);
        }

        return "Courses Imported Successfully";
    }

    // -----------------------------------------
    // 3) COURSE ENROLMENTS IMPORT
    // -----------------------------------------
    public function importCourseEnrolments()
    {
        $data = $this->readExcel("course_enrolments.xlsx");
        if (!$data['status']) return $data;

        $rows = $data['rows'];
        $insert = [];

        foreach ($rows as $r) {
            if (!isset($r[0])) continue;

            $insert[] = [
                'id'         => $r[0],
                'user_id'    => $r[1] ?? null,
                'course_id'  => $r[2] ?? null,
                'is_active'  => $r[3] ?? 1,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        foreach (array_chunk($insert, 500) as $chunk) {
            DB::table('course_enrolments')->insertOrIgnore($chunk);
        }

        return "Course Enrolments Imported Successfully";
    }

    // -----------------------------------------
    // 4) COURSE MATERIALS IMPORT
    // -----------------------------------------
    public function importCourseMaterials()
    {
        $data = $this->readExcel("course_materials.xlsx");
        if (!$data['status']) return $data;

        $rows = $data['rows'];
        $insert = [];

        foreach ($rows as $r) {
            if (!isset($r[0])) continue;

            $insert[] = [
                'id'          => $r[0],
                'course_id'   => $r[1] ?? null,
                'title'       => $r[2] ?? '',
                'description' => $r[3] ?? null,
                'attachments' => $r[4] ?? null,
                'is_active'   => $r[5] ?? 1,
                'created_at'  => now(),
                'updated_at'  => now(),
            ];
        }

        foreach (array_chunk($insert, 500) as $chunk) {
            DB::table('course_materials')->insertOrIgnore($chunk);
        }

        return "Course Materials Imported Successfully";
    }

    // -----------------------------------------
    // 5) USERS IMPORT
    // -----------------------------------------
    public function importUsers()
    {
        $data = $this->readExcel("tblusers.csv");
        if (!$data['status']) return $data;

        $rows = $data['rows'];
        $insert = [];

        array_shift($rows); // removes first row

        foreach ($rows as $r) {

            //dd($r);

            if (!isset($r[0])) continue;

            $insert[] = [
                'id'                 => $r[0],
                'role_id'            => 3,
                'company_id'         => null,
                'name'               => ucwords($r[4]),
                'email'              => $r[1] ?? null,
                'phone'              => $r[3] ?? null,
                'location'           => $r[5] ?? null,
                'is_active'          => 1,
                'email_verified_at'  => null,
                'password'           => null,
                'remember_token'     => null,
                'created_at'         => (!empty($r[15]) && $r[15] != '0000-00-00 00:00:00') ? $r[15] : now(),
                'updated_at'         => now(),
            ];
        }

        foreach (array_chunk($insert, 100) as $chunk) {
            DB::table('users')->insertOrIgnore($chunk);
        }

        return "Users Imported Successfully";
    }

}
