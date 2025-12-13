<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

//Backend
use App\Http\Controllers\CommandController;
use App\Http\Controllers\Backend\AuthController;
use App\Http\Controllers\Backend\UploadController;
use App\Http\Controllers\Backend\CompanyController;
use App\Http\Controllers\Backend\CourseCategoryController;
use App\Http\Controllers\Backend\CourseController;
use App\Http\Controllers\Backend\CourseMaterialController;
use App\Http\Controllers\Backend\CourseEnrolmentController;
use App\Http\Controllers\Backend\StudentController;
use App\Http\Controllers\Backend\TeamController;
use App\Http\Controllers\Backend\CampusController;
use App\Http\Controllers\Backend\GalleryController;
use App\Http\Controllers\Backend\PageController;
use App\Http\Controllers\Backend\FormController as BackendFormController;
use App\Http\Controllers\Backend\ImportController;

//Frontend
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\FormController;

Route::prefix('command')->group(function () {
    Route::get('cache-clear', [CommandController::class, 'cacheClear']);
    Route::get('config-clear', [CommandController::class, 'configClear']);
    Route::get('config-cache', [CommandController::class, 'configCache']);
    Route::get('route-cache', [CommandController::class, 'routeCache']);
    Route::get('route-clear', [CommandController::class, 'routeClear']);
    Route::get('view-clear', [CommandController::class, 'viewClear']);
    Route::get('view-cache', [CommandController::class, 'viewCache']);
    Route::get('storage-link', [CommandController::class, 'storageLink']);
    Route::get('key-generate', [CommandController::class, 'keyGenerate']);
    Route::get('optimize-clear', [CommandController::class, 'optimizeClear']);
    Route::get('queue-work', [CommandController::class, 'queueWork']);
    Route::get('queue-retry/{id?}', [CommandController::class, 'queueRetry']); // optional id
    Route::get('queue-failed', [CommandController::class, 'queueFailed']);
    Route::get('queue-forget/{id}', [CommandController::class, 'queueForget']);
    Route::get('queue-flush', [CommandController::class, 'queueFlush']);    
});

// Route::get('/', [FrontendController::class, 'home'])->name('home');

// Route::get('/about-us', [FrontendController::class, 'about'])->name('about');

// Route::get('/products', [FrontendController::class, 'products'])->name('products');

// Route::get('/contact-us', [FrontendController::class, 'contact'])->name('contact');

// Route::post('/submit-form', [FormController::class, 'submit'])->middleware(['protect.forms','recaptcha','throttle:4,1'])->name('form.submit');

// Group routes under the 'backend' prefix
Route::prefix('backend')->group(function () {

    // Public login/logout routes
    Route::get('/', [AuthController::class, 'showLoginForm'])->middleware(['auth.guest', 'auth.backend.access'])->name('backend.login');
    Route::get('/login', [AuthController::class, 'showLoginForm'])->middleware(['auth.guest', 'auth.backend.access'])->name('backend.login');
    Route::post('/login', [AuthController::class, 'login'])->middleware(['recaptcha','throttle:10,60'])->name('backend.login.submit');
    Route::get('/logout', [AuthController::class, 'logout'])->name('backend.logout');

    // Authenticated admin routes
    Route::middleware(['auth.backend'])->group(function () {
        Route::get('/dashboard', function () {
            return view('backend.dashboard');
        })->name('backend.dashboard');
    });

    // Uploads routes 
    Route::middleware(['auth.backend'])->resource('/uploaded-files', UploadController::class);
    Route::middleware(['auth.backend'])->controller(UploadController::class)->group(function () {
        Route::any('/uploaded-files/file-info', 'file_info')->name('uploaded-files.info');
        Route::get('/uploaded-files/destroy/{id}', 'destroy')->name('uploaded-files.destroy');
        Route::post('/bulk-uploaded-files-delete', 'bulk_uploaded_files_delete')->name('bulk-uploaded-files-delete');
        Route::get('/all-file', 'all_file');
        Route::post('/aiz-uploader', 'show_uploader');
        Route::post('/aiz-uploader/upload', 'upload');
        Route::get('/aiz-uploader/get-uploaded-files', 'get_uploaded_files');
        Route::post('/aiz-uploader/get_file_by_ids', 'get_preview_files');
        Route::get('/aiz-uploader/download/{id}', 'attachment_download')->name('download_attachment');   
        Route::get('/aiz-uploader/generate-all-thumbnail', 'generate_all_thumbnails');     
    }); 
    
    // Schools routes
    Route::middleware(['auth.backend'])->group(function () {
        Route::get('/schools', function () {
            return view('backend.schools.index');
        })->name('backend.schools');
    });   
    
    Route::middleware('auth.backend')->group(function () {
        Route::resource('companies', CompanyController::class);
    });  

    Route::middleware('auth.backend')->group(function () {
        Route::resource('pages', PageController::class);
    });  

    Route::middleware('auth.backend')->group(function () {
        Route::resource('course-categories', CourseCategoryController::class);
    });  

    Route::middleware('auth.backend')->group(function () {
        Route::resource('courses', CourseController::class);
        Route::post('courses/bulk-delete', [CourseController::class, 'bulkDelete'])->name('courses.bulk-delete');
        Route::post('courses/bulk-active', [CourseController::class, 'bulkActive'])->name('courses.bulk-active');
        Route::post('courses/bulk-inactive', [CourseController::class, 'bulkInactive'])->name('courses.bulk-inactive');
    });  

    // AJAX route to get courses by category (used in Course Materials page filter)
    Route::middleware('auth.backend')->get('ajax/courses-by-category', [CourseController::class, 'getByCategory'])->name('courses.by-category');

    Route::middleware('auth.backend')->group(function () {
        Route::resource('course-materials', CourseMaterialController::class);
        Route::post('course-materials/bulk-delete', [CourseMaterialController::class, 'bulkDelete'])->name('course-materials.bulk-delete');
        Route::post('course-materials/bulk-active', [CourseMaterialController::class, 'bulkActive'])->name('course-materials.bulk-active');
        Route::post('course-materials/bulk-inactive', [CourseMaterialController::class, 'bulkInactive'])->name('course-materials.bulk-inactive');
    });  

    Route::middleware('auth.backend')->group(function () {
        Route::resource('course-enrolments', CourseEnrolmentController::class);
    });  

    Route::middleware('auth.backend')->group(function () {
        Route::resource('students', StudentController::class);
        Route::post('students/bulk-delete', [StudentController::class, 'bulkDelete'])->name('students.bulk-delete');
        Route::post('students/bulk-active', [StudentController::class, 'bulkActive'])->name('students.bulk-active');
        Route::post('students/bulk-inactive', [StudentController::class, 'bulkInactive'])->name('students.bulk-inactive');
    });  
    
    Route::middleware('auth.backend')->group(function () {
        Route::get('forms-by/{form_name}', [BackendFormController::class, 'index'])->name('forms.by');
    });

    Route::get('/import-course-categories', [ImportController::class, 'importCourseCategories']);
    Route::get('/import-courses', [ImportController::class, 'importCourses']);
    Route::get('/import-course-enrolments', [ImportController::class, 'importCourseEnrolments']);
    Route::get('/import-course-materials', [ImportController::class, 'importCourseMaterials']); 
    Route::get('/import-users', [ImportController::class, 'importUsers']);   
});


//Page Routes
// Route::get('{slug}', function ($slug) {
//     //$page = DB::table('pages')->where('slug', $slug)->first();
//     $page = DB::table('pages')->where('slug', $slug)->where('company_id', config('custom.school_id'))->first();

//     if (!$page) {
//         abort(404);
//     }

//     switch ($page->layout) {
//         case 'circulars':
//             return app(FrontendController::class)->circulars($page->slug);
//         case 'achivements':
//             return app(FrontendController::class)->achivements($page->slug);
//         case 'newsletter':
//             return app(FrontendController::class)->newsletter($page->slug);  
//         case 'default':
//             return app(FrontendController::class)->default($page->slug);           
//         default:
//             abort(404, 'Route needs to be manually define.');
//     }
// })->where('slug', '.*');