@extends('frontend.layouts.app')

@section('meta.title', 'Contact Us')
@section('meta.description', 'Contact Us')

@section('content')

@include('frontend.partials.breadcrumb', ['title' => "Courses"])

@foreach($courseCategories as $index => $category)
   <!-- <section class="courses_section pb-5 pt-5">
      <div class="container">
         <div class="row g-4 align-items-center @if($index % 2 == 1) flex-lg-row-reverse @endif">
            <div class="col-lg-6 position-relative" data-aos="fade-right" data-aos-duration="1000" data-aos-once="true">
               <div class="position-relative">
                  <img src="{{ uploaded_asset($category->image) }}"
                     alt="{{ $category->name }} training" class="hvr-bounce-in w-100 course-card-img">
                  <div class="position-absolute top-3 start-3">
                     <span class="badge bg-primary text-white badge-count">{{ $category->courses_count }} Courses</span>
                  </div>
               </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left" data-aos-duration="1000" data-aos-once="true">
               <h3 class=" robot_slab">{{ $category->name }}</h3>
               <p>{!! $category->description !!}</p>
            </div>
         </div>
      </div>
   </section> -->

   
@endforeach

<section class="courses_section pb-5 pt-5">
   <div class="container">
      <div class="row g-4">
         <!-- Online Courses Section -->
         <div class="col-lg-6 pe-lg-5" id="online-course">
            <h2 class="robot_slab text_color mb-4">
               <i class="fa-solid fa-laptop me-2"></i> Online Course
            </h2>
            <ul class="course-list list-unstyled">
               <li class="course-item pb-3 border-bottom">
                  <div class="d-flex align-items-center justify-content-between">
                     <div class="d-flex align-items-center">
                        <span class="course-bullet me-3"></span>
                        <span class="course-name">ME engine course simulator training</span>
                     </div>
                     <a href="assets/frontend/img/courses_pdf.pdf" class="btn btn-sm btn-outline-primary" download>
                        <i class="fas fa-file-pdf"></i>
                     </a>
                  </div>
               </li>
               <li class="course-item pb-3 border-bottom">
                  <div class="d-flex align-items-center justify-content-between">
                     <div class="d-flex align-items-center">
                        <span class="course-bullet me-3"></span>
                        <span class="course-name">Mental health for seafarers course</span>
                     </div>
                     <a href="assets/frontend/img/courses_pdf.pdf" class="btn btn-sm btn-outline-primary" download>
                        <i class="fas fa-file-pdf"></i>
                     </a>
                  </div>
               </li>
               <li class="course-item pb-3 border-bottom">
                  <div class="d-flex align-items-center justify-content-between">
                     <div class="d-flex align-items-center">
                        <span class="course-bullet me-3"></span>
                        <span class="course-name">Advanced hydraulics course                     </span>
                     </div>
                     <a href="assets/frontend/img/courses_pdf.pdf" class="btn btn-sm btn-outline-primary" download>
                        <i class="fas fa-file-pdf"></i>
                     </a>
                  </div>
               </li>
               <li class="course-item pb-3 border-bottom">
                  <div class="d-flex align-items-center justify-content-between">
                     <div class="d-flex align-items-center">
                        <span class="course-bullet me-3"></span>
                        <span class="course-name">Basic hydraulic course                     </span>
                     </div>
                     <a href="assets/frontend/img/courses_pdf.pdf" class="btn btn-sm btn-outline-primary" download>
                        <i class="fas fa-file-pdf"></i>
                     </a>
                  </div>
               </li>
               <li class="course-item pb-3 border-bottom">
                  <div class="d-flex align-items-center justify-content-between">
                     <div class="d-flex align-items-center">
                        <span class="course-bullet me-3"></span>
                        <span class="course-name">Automation and instrumentation course                     </span>
                     </div>
                     <a href="assets/frontend/img/courses_pdf.pdf" class="btn btn-sm btn-outline-primary" download>
                        <i class="fas fa-file-pdf"></i>
                     </a>
                  </div>
               </li>
               <li class="course-item pb-3 border-bottom">
                  <div class="d-flex align-items-center justify-content-between">
                     <div class="d-flex align-items-center">
                        <span class="course-bullet me-3"></span>
                        <span class="course-name">Framo hydraulic cargo pumping system course                     </span>
                     </div>
                     <a href="assets/frontend/img/courses_pdf.pdf" class="btn btn-sm btn-outline-primary" download>
                        <i class="fas fa-file-pdf"></i>
                     </a>
                  </div>
               </li>
               <li class="course-item pb-3 border-bottom">
                  <div class="d-flex align-items-center justify-content-between">
                     <div class="d-flex align-items-center">
                        <span class="course-bullet me-3"></span>
                        <span class="course-name">Training program for gas engineer                     </span>
                     </div>
                     <a href="assets/frontend/img/courses_pdf.pdf" class="btn btn-sm btn-outline-primary" download>
                        <i class="fas fa-file-pdf"></i>
                     </a>
                  </div>
               </li>
               <li class="course-item pb-3 border-bottom">
                  <div class="d-flex align-items-center justify-content-between">
                     <div class="d-flex align-items-center">
                        <span class="course-bullet me-3"></span>
                        <span class="course-name">Bridge team resource management                     </span>
                     </div>
                     <a href="assets/frontend/img/courses_pdf.pdf" class="btn btn-sm btn-outline-primary" download>
                        <i class="fas fa-file-pdf"></i>
                     </a>
                  </div>
               </li>
               <li class="course-item pb-3 border-bottom">
                  <div class="d-flex align-items-center justify-content-between">
                     <div class="d-flex align-items-center">
                        <span class="course-bullet me-3"></span>
                        <span class="course-name">Electrical drawing course                     </span>
                     </div>
                     <a href="assets/frontend/img/courses_pdf.pdf" class="btn btn-sm btn-outline-primary" download>
                        <i class="fas fa-file-pdf"></i>
                     </a>
                  </div>
               </li>
               <li class="course-item pb-3 border-bottom">
                  <div class="d-flex align-items-center justify-content-between">
                     <div class="d-flex align-items-center">
                        <span class="course-bullet me-3"></span>
                        <span class="course-name">Risk management and accident investigation course                     </span>
                     </div>
                     <a href="assets/frontend/img/courses_pdf.pdf" class="btn btn-sm btn-outline-primary" download>
                        <i class="fas fa-file-pdf"></i>
                     </a>
                  </div>
               </li>
               <li class="course-item pb-3 border-bottom">
                  <div class="d-flex align-items-center justify-content-between">
                     <div class="d-flex align-items-center">
                        <span class="course-bullet me-3"></span>
                        <span class="course-name">Sire 2.0                     </span>
                     </div>
                     <a href="assets/frontend/img/courses_pdf.pdf" class="btn btn-sm btn-outline-primary" download>
                        <i class="fas fa-file-pdf"></i>
                     </a>
                  </div>
               </li>
               <li class="course-item pb-3 border-bottom">
                  <div class="d-flex align-items-center justify-content-between">
                     <div class="d-flex align-items-center">
                        <span class="course-bullet me-3"></span>
                        <span class="course-name">Auxiliary diesel engine maintenance course                     </span>
                     </div>
                     <a href="assets/frontend/img/courses_pdf.pdf" class="btn btn-sm btn-outline-primary" download>
                        <i class="fas fa-file-pdf"></i>
                     </a>
                  </div>
               </li>
               <li class="course-item pb-3 border-bottom">
                  <div class="d-flex align-items-center justify-content-between">
                     <div class="d-flex align-items-center">
                        <span class="course-bullet me-3"></span>
                        <span class="course-name">Chief engineer command course                     </span>
                     </div>
                     <a href="assets/frontend/img/courses_pdf.pdf" class="btn btn-sm btn-outline-primary" download>
                        <i class="fas fa-file-pdf"></i>
                     </a>
                  </div>
               </li>
               <li class="course-item pb-3 border-bottom">
                  <div class="d-flex align-items-center justify-content-between">
                     <div class="d-flex align-items-center">
                        <span class="course-bullet me-3"></span>
                        <span class="course-name">Ship security officer                     </span>
                     </div>
                     <a href="assets/frontend/img/courses_pdf.pdf" class="btn btn-sm btn-outline-primary" download>
                        <i class="fas fa-file-pdf"></i>
                     </a>
                  </div>
               </li>
               <li class="course-item pb-3 border-bottom">
                  <div class="d-flex align-items-center justify-content-between">
                     <div class="d-flex align-items-center">
                        <span class="course-bullet me-3"></span>
                        <span class="course-name">Gender sensitization course                     </span>
                     </div>
                     <a href="assets/frontend/img/courses_pdf.pdf" class="btn btn-sm btn-outline-primary" download>
                        <i class="fas fa-file-pdf"></i>
                     </a>
                  </div>
               </li>
               <li class="course-item pb-3 border-bottom">
                  <div class="d-flex align-items-center justify-content-between">
                     <div class="d-flex align-items-center">
                        <span class="course-bullet me-3"></span>
                        <span class="course-name">Engine room simulator refresher and engine room team resource management                     </span>
                     </div>
                     <a href="assets/frontend/img/courses_pdf.pdf" class="btn btn-sm btn-outline-primary" download>
                        <i class="fas fa-file-pdf"></i>
                     </a>
                  </div>
               </li>
               <li class="course-item pb-3 border-bottom">
                  <div class="d-flex align-items-center justify-content-between">
                     <div class="d-flex align-items-center">
                        <span class="course-bullet me-3"></span>
                        <span class="course-name">Tanker cargo operation                     </span>
                     </div>
                     <a href="assets/frontend/img/courses_pdf.pdf" class="btn btn-sm btn-outline-primary" download>
                        <i class="fas fa-file-pdf"></i>
                     </a>
                  </div>
               </li>
               <li class="course-item pb-3 border-bottom">
                  <div class="d-flex align-items-center justify-content-between">
                     <div class="d-flex align-items-center">
                        <span class="course-bullet me-3"></span>
                        <span class="course-name">Onboard seafarer's assessment                     </span>
                     </div>
                     <a href="assets/frontend/img/courses_pdf.pdf" class="btn btn-sm btn-outline-primary" download>
                        <i class="fas fa-file-pdf"></i>
                     </a>
                  </div>
               </li>
               <li class="course-item pb-3 border-bottom">
                  <div class="d-flex align-items-center justify-content-between">
                     <div class="d-flex align-items-center">
                        <span class="course-bullet me-3"></span>
                        <span class="course-name">Hull Structure Inspection Course                     </span>
                     </div>
                     <a href="assets/frontend/img/courses_pdf.pdf" class="btn btn-sm btn-outline-primary" download>
                        <i class="fas fa-file-pdf"></i>
                     </a>
                  </div>
               </li>
               <li class="course-item pb-3 border-bottom">
                  <div class="d-flex align-items-center justify-content-between">
                     <div class="d-flex align-items-center">
                        <span class="course-bullet me-3"></span>
                        <span class="course-name">ME - GI course                     </span>
                     </div>
                     <a href="assets/frontend/img/courses_pdf.pdf" class="btn btn-sm btn-outline-primary" download>
                        <i class="fas fa-file-pdf"></i>
                     </a>
                  </div>
               </li>
               <li class="course-item pb-3 border-bottom">
                  <div class="d-flex align-items-center justify-content-between">
                     <div class="d-flex align-items-center">
                        <span class="course-bullet me-3"></span>
                        <span class="course-name">Training Program for Gas Engineers                     </span>
                     </div>
                     <a href="assets/frontend/img/courses_pdf.pdf" class="btn btn-sm btn-outline-primary" download>
                        <i class="fas fa-file-pdf"></i>
                     </a>
                  </div>
               </li>
               <li class="course-item mb-3 border-bottom">
                  <div class="d-flex align-items-center justify-content-between">
                     <div class="d-flex align-items-center">
                        <span class="course-bullet me-3"></span>
                        <span class="course-name">CII Rating Training                     </span>
                     </div>
                     <a href="assets/frontend/img/courses_pdf.pdf" class="btn btn-sm btn-outline-primary" download>
                        <i class="fas fa-file-pdf"></i>
                     </a>
                  </div>
               </li>
            </ul>
         </div>

         <!-- Offline Courses Section -->
         <div class="col-lg-6 ps-lg-5" id="offline-course">
            <h2 class="robot_slab text_color mb-4">
               <i class="fa-solid fa-chalkboard me-2"></i> Offline Course
            </h2>
            <ul class="course-list list-unstyled">
               <li class="course-item pb-3 border-bottom">
                  <div class="d-flex align-items-center justify-content-between">
                     <div class="d-flex align-items-center">
                        <span class="course-bullet me-3"></span>
                        <span class="course-name">Framo hydraulic cargo pumping system course                     </span>
                     </div>
                     <a href="assets/frontend/img/courses_pdf.pdf" class="btn btn-sm btn-outline-primary" download>
                        <i class="fas fa-file-pdf"></i>
                     </a>
                  </div>
               </li>
               <li class="course-item pb-3 border-bottom">
                  <div class="d-flex align-items-center justify-content-between">
                     <div class="d-flex align-items-center">
                        <span class="course-bullet me-3"></span>
                        <span class="course-name">Risk management and accident investigation course                     </span>
                     </div>
                     <a href="assets/frontend/img/courses_pdf.pdf" class="btn btn-sm btn-outline-primary" download>
                        <i class="fas fa-file-pdf"></i>
                     </a>
                  </div>
               </li>
               <li class="course-item pb-3 border-bottom">
                  <div class="d-flex align-items-center justify-content-between">
                     <div class="d-flex align-items-center">
                        <span class="course-bullet me-3"></span>
                        <span class="course-name">Chief engineer command course                     </span>
                     </div>
                     <a href="assets/frontend/img/courses_pdf.pdf" class="btn btn-sm btn-outline-primary" download>
                        <i class="fas fa-file-pdf"></i>
                     </a>
                  </div>
               </li>
               <li class="course-item pb-3 border-bottom">
                  <div class="d-flex align-items-center justify-content-between">
                     <div class="d-flex align-items-center">
                        <span class="course-bullet me-3"></span>
                        <span class="course-name">Gender sensitization course                     </span>
                     </div>
                     <a href="assets/frontend/img/courses_pdf.pdf" class="btn btn-sm btn-outline-primary" download>
                        <i class="fas fa-file-pdf"></i>
                     </a>
                  </div>
               </li>
               <li class="course-item pb-3 border-bottom">
                  <div class="d-flex align-items-center justify-content-between">
                     <div class="d-flex align-items-center">
                        <span class="course-bullet me-3"></span>
                        <span class="course-name">Mental health for seafarers course</span>
                     </div>
                     <a href="assets/frontend/img/courses_pdf.pdf" class="btn btn-sm btn-outline-primary" download>
                        <i class="fas fa-file-pdf"></i>
                     </a>
                  </div>
               </li>
               <li class="course-item pb-3 border-bottom">
                  <div class="d-flex align-items-center justify-content-between">
                     <div class="d-flex align-items-center">
                        <span class="course-bullet me-3"></span>
                        <span class="course-name">Engine room simulator refresher and engine room team resource management                     </span>
                     </div>
                     <a href="assets/frontend/img/courses_pdf.pdf" class="btn btn-sm btn-outline-primary" download>
                        <i class="fas fa-file-pdf"></i>
                     </a>
                  </div>
               </li>
               <li class="course-item pb-3 border-bottom">
                  <div class="d-flex align-items-center justify-content-between">
                     <div class="d-flex align-items-center">
                        <span class="course-bullet me-3"></span>
                        <span class="course-name">Basic hydraulic workshop                     </span>
                     </div>
                     <a href="assets/frontend/img/courses_pdf.pdf" class="btn btn-sm btn-outline-primary" download>
                        <i class="fas fa-file-pdf"></i>
                     </a>
                  </div>
               </li>
               <li class="course-item pb-3 border-bottom">
                  <div class="d-flex align-items-center justify-content-between">
                     <div class="d-flex align-items-center">
                        <span class="course-bullet me-3"></span>
                        <span class="course-name">Advanced hydraulics workshop                     </span>
                     </div>
                     <a href="assets/frontend/img/courses_pdf.pdf" class="btn btn-sm btn-outline-primary" download>
                        <i class="fas fa-file-pdf"></i>
                     </a>
                  </div>
               </li>
               <li class="course-item pb-3 border-bottom">
                  <div class="d-flex align-items-center justify-content-between">
                     <div class="d-flex align-items-center">
                        <span class="course-bullet me-3"></span>
                        <span class="course-name">Pneumatics and manoeuvring system course                     </span>
                     </div>
                     <a href="assets/frontend/img/courses_pdf.pdf" class="btn btn-sm btn-outline-primary" download>
                        <i class="fas fa-file-pdf"></i>
                     </a>
                  </div>
               </li>
               <li class="course-item pb-3 border-bottom">
                  <div class="d-flex align-items-center justify-content-between">
                     <div class="d-flex align-items-center">
                        <span class="course-bullet me-3"></span>
                        <span class="course-name">NK-O3 ballast water treatment system (BWTS) operations and troubleshooting course                     </span>
                     </div>
                     <a href="assets/frontend/img/courses_pdf.pdf" class="btn btn-sm btn-outline-primary" download>
                        <i class="fas fa-file-pdf"></i>
                     </a>
                  </div>
               </li>
               <li class="course-item pb-3 border-bottom">
                  <div class="d-flex align-items-center justify-content-between">
                     <div class="d-flex align-items-center">
                        <span class="course-bullet me-3"></span>
                        <span class="course-name">Samsung Purimar ballast water treatment system (BWTS) operations and troubleshooting course                     </span>
                     </div>
                     <a href="assets/frontend/img/courses_pdf.pdf" class="btn btn-sm btn-outline-primary" download>
                        <i class="fas fa-file-pdf"></i>
                     </a>
                  </div>
               </li>
               <li class="course-item pb-3 border-bottom">
                  <div class="d-flex align-items-center justify-content-between">
                     <div class="d-flex align-items-center">
                        <span class="course-bullet me-3"></span>
                        <span class="course-name">Hyundai HiBallast water treatment system (BWTS) operations and troubleshooting course                     </span>
                     </div>
                     <a href="assets/frontend/img/courses_pdf.pdf" class="btn btn-sm btn-outline-primary" download>
                        <i class="fas fa-file-pdf"></i>
                     </a>
                  </div>
               </li>
               <li class="course-item pb-3 border-bottom">
                  <div class="d-flex align-items-center justify-content-between">
                     <div class="d-flex align-items-center">
                        <span class="course-bullet me-3"></span>
                        <span class="course-name">Hull Structure Inspection Course                     </span>
                     </div>
                     <a href="assets/frontend/img/courses_pdf.pdf" class="btn btn-sm btn-outline-primary" download>
                        <i class="fas fa-file-pdf"></i>
                     </a>
                  </div>
               </li>
               <li class="course-item mb-3 border-bottom">
                  <div class="d-flex align-items-center justify-content-between">
                     <div class="d-flex align-items-center">
                        <span class="course-bullet me-3"></span>
                        <span class="course-name">CII Rating Training                     </span>
                     </div>
                     <a href="assets/frontend/img/courses_pdf.pdf" class="btn btn-sm btn-outline-primary" download>
                        <i class="fas fa-file-pdf"></i>
                     </a>
                  </div>
               </li>
            </ul>
         </div>
      </div>
   </div>
</section>

<!-- Enroll Now Button Section -->
<section class="enroll-section pb-5 pt-4">
   <div class="container">
      <div class="row">
         <div class="col-12 text-center">
            <button type="button" class="btn btn-primary btn-lg enroll-btn robot_slab" data-bs-toggle="modal" data-bs-target="#enrollModal">
               ENROLL NOW
            </button>
         </div>
      </div>
   </div>
</section>

<!-- Enroll Modal -->
<div class="modal fade" id="enrollModal" tabindex="-1" aria-labelledby="enrollModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title robot_slab" id="enrollModalLabel">Enroll in Course</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <form id="enrollForm">
               <div class="row">
               <div class="col-md-12">
               <label class="form-label robot_slab fw-bold">Select Course Type:</label>
               </div>
                  <div class="col-md-6">

                  <div class="mb-4">
                  
                  <div class="form-check">
                     <input class="form-check-input" type="radio" name="courseType" id="onlineType" value="online" checked>
                     <label class="form-check-label" for="onlineType">
                        <i class="fa-solid fa-laptop me-2"></i> Online Course
                     </label>
                  </div>
                 
               </div>


                  </div>
                  <div class="col-md-6">

                  <div class="mb-4">
                  
                  <div class="form-check">
                     <input class="form-check-input" type="radio" name="courseType" id="offlineType" value="offline">
                     <label class="form-check-label" for="offlineType">
                        <i class="fa-solid fa-chalkboard me-2"></i> Offline Course
                     </label>
                  </div>
               </div>


                  </div>
               </div>
               
               
               <div class="mb-4">
                  <label for="courseSelect" class="form-label robot_slab fw-bold">Select Course:</label>
                  <select class="form-select" id="courseSelect" name="course" required>
                     <option value="">-- Select a course --</option>
                     <optgroup label="Online Courses">
                        <option value="ME engine course simulator training">ME engine course simulator training</option>
                        <option value="Mental health for seafarers course">Mental health for seafarers course</option>
                        <option value="Advanced hydraulics course">Advanced hydraulics course</option>
                        <option value="Basic hydraulic course">Basic hydraulic course</option>
                        <option value="Automation and instrumentation course">Automation and instrumentation course</option>
                        <option value="Framo hydraulic cargo pumping system course">Framo hydraulic cargo pumping system course</option>
                        <option value="Training program for gas engineer">Training program for gas engineer</option>
                        <option value="Bridge team resource management">Bridge team resource management</option>
                        <option value="Electrical drawing course">Electrical drawing course</option>
                        <option value="Risk management and accident investigation course">Risk management and accident investigation course</option>
                        <option value="Sire 2.0">Sire 2.0</option>
                        <option value="Auxiliary diesel engine maintenance course">Auxiliary diesel engine maintenance course</option>
                        <option value="Chief engineer command course">Chief engineer command course</option>
                        <option value="Ship security officer">Ship security officer</option>
                        <option value="Gender sensitization course">Gender sensitization course</option>
                        <option value="Engine room simulator refresher and engine room team resource management">Engine room simulator refresher and engine room team resource management</option>
                        <option value="Tanker cargo operation">Tanker cargo operation</option>
                        <option value="Onboard seafarer's assessment">Onboard seafarer's assessment</option>
                        <option value="Hull Structure Inspection Course">Hull Structure Inspection Course</option>
                        <option value="ME - GI course">ME - GI course</option>
                        <option value="Training Program for Gas Engineers">Training Program for Gas Engineers</option>
                        <option value="CII Rating Training">CII Rating Training</option>
                     </optgroup>
                     <optgroup label="Offline Courses">
                        <option value="Framo hydraulic cargo pumping system course">Framo hydraulic cargo pumping system course</option>
                        <option value="Risk management and accident investigation course">Risk management and accident investigation course</option>
                        <option value="Chief engineer command course">Chief engineer command course</option>
                        <option value="Gender sensitization course">Gender sensitization course</option>
                        <option value="Mental health for seafarers course">Mental health for seafarers course</option>
                        <option value="Engine room simulator refresher and engine room team resource management">Engine room simulator refresher and engine room team resource management</option>
                        <option value="Basic hydraulic workshop">Basic hydraulic workshop</option>
                        <option value="Advanced hydraulics workshop">Advanced hydraulics workshop</option>
                        <option value="Pneumatics and manoeuvring system course">Pneumatics and manoeuvring system course</option>
                        <option value="NK-O3 ballast water treatment system (BWTS) operations and troubleshooting course">NK-O3 ballast water treatment system (BWTS) operations and troubleshooting course</option>
                        <option value="Samsung Purimar ballast water treatment system (BWTS) operations and troubleshooting course">Samsung Purimar ballast water treatment system (BWTS) operations and troubleshooting course</option>
                        <option value="Hyundai HiBallast water treatment system (BWTS) operations and troubleshooting course">Hyundai HiBallast water treatment system (BWTS) operations and troubleshooting course</option>
                        <option value="Hull Structure Inspection Course">Hull Structure Inspection Course</option>
                        <option value="CII Rating Training">CII Rating Training</option>
                     </optgroup>
                  </select>
               </div>
               
               <div class="text-center">
                  <button type="submit" class="btn btn-primary robot_slab">Enroll</button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>

@push('scripts')
<script>
   $(document).ready(function() {
      // Handle form submission
      $('#enrollForm').on('submit', function(e) {
         e.preventDefault();
         
         var courseType = $('input[name="courseType"]:checked').val();
         var course = $('#courseSelect').val();
         
         if (!course) {
            alert('Please select a course');
            return;
         }
         
         // Here you can add AJAX call to submit enrollment
         // For now, just show an alert
         alert('Enrollment request submitted for: ' + course + ' (' + courseType + ')');
         
         // Close modal
         $('#enrollModal').modal('hide');
         
         // Reset form
         $('#enrollForm')[0].reset();
         $('#onlineType').prop('checked', true);
      });
   });
</script>
@endpush

@endsection
