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

<section id="online-course" class="courses_section pb-5 pt-5">
   <div class="container">
      <div class="row">
         <div class="col-12">
            <h2 class="robot_slab text_color mb-4">ONLINE COURSE</h2>
            <ul class="course-list list-unstyled">
               <li class="course-item pb-3 border-bottom">
                  <div class="d-flex justify-content-between align-items-center">
                     <span class="course-name">ME engine course simulator training</span>
                     <a href="assets/frontend/img/courses_pdf.pdf" class="btn btn-sm btn-outline-primary" download>
                        <i class="fas fa-file-pdf me-1"></i> PDF
                     </a>
                  </div>
               </li>
               <li class="course-item pb-3 border-bottom">
                  <div class="d-flex justify-content-between align-items-center">
                     <span class="course-name">Mental health for seafarers course</span>
                     <a href="assets/frontend/img/courses_pdf.pdf" class="btn btn-sm btn-outline-primary" download>
                        <i class="fas fa-file-pdf me-1"></i> PDF
                     </a>
                  </div>
               </li>
               <li class="course-item pb-3 border-bottom">
                  <div class="d-flex justify-content-between align-items-center">
                     <span class="course-name">Advanced hydraulics course</span>
                     <a href="assets/frontend/img/courses_pdf.pdf" class="btn btn-sm btn-outline-primary" download>
                        <i class="fas fa-file-pdf me-1"></i> PDF
                     </a>
                  </div>
               </li>
               <li class="course-item pb-3 border-bottom">
                  <div class="d-flex justify-content-between align-items-center">
                     <span class="course-name">Basic hydraulic course</span>
                     <a href="assets/frontend/img/courses_pdf.pdf" class="btn btn-sm btn-outline-primary" download>
                        <i class="fas fa-file-pdf me-1"></i> PDF
                     </a>
                  </div>
               </li>
               <li class="course-item pb-3 border-bottom">
                  <div class="d-flex justify-content-between align-items-center">
                     <span class="course-name">Automation and instrumentation course</span>
                     <a href="assets/frontend/img/courses_pdf.pdf" class="btn btn-sm btn-outline-primary" download>
                        <i class="fas fa-file-pdf me-1"></i> PDF
                     </a>
                  </div>
               </li>
               <li class="course-item pb-3 border-bottom">
                  <div class="d-flex justify-content-between align-items-center">
                     <span class="course-name">Framo hydraulic cargo pumping system course</span>
                     <a href="assets/frontend/img/courses_pdf.pdf" class="btn btn-sm btn-outline-primary" download>
                        <i class="fas fa-file-pdf me-1"></i> PDF
                     </a>
                  </div>
               </li>
               <li class="course-item pb-3 border-bottom">
                  <div class="d-flex justify-content-between align-items-center">
                     <span class="course-name">Training program for gas engineer</span>
                     <a href="assets/frontend/img/courses_pdf.pdf" class="btn btn-sm btn-outline-primary" download>
                        <i class="fas fa-file-pdf me-1"></i> PDF
                     </a>
                  </div>
               </li>
               <li class="course-item pb-3 border-bottom">
                  <div class="d-flex justify-content-between align-items-center">
                     <span class="course-name">Bridge team resource management</span>
                     <a href="assets/frontend/img/courses_pdf.pdf" class="btn btn-sm btn-outline-primary" download>
                        <i class="fas fa-file-pdf me-1"></i> PDF
                     </a>
                  </div>
               </li>
               <li class="course-item pb-3 border-bottom">
                  <div class="d-flex justify-content-between align-items-center">
                     <span class="course-name">Electrical drawing course</span>
                     <a href="assets/frontend/img/courses_pdf.pdf" class="btn btn-sm btn-outline-primary" download>
                        <i class="fas fa-file-pdf me-1"></i> PDF
                     </a>
                  </div>
               </li>
               <li class="course-item pb-3 border-bottom">
                  <div class="d-flex justify-content-between align-items-center">
                     <span class="course-name">Risk management and accident investigation course</span>
                     <a href="assets/frontend/img/courses_pdf.pdf" class="btn btn-sm btn-outline-primary" download>
                        <i class="fas fa-file-pdf me-1"></i> PDF
                     </a>
                  </div>
               </li>
               <li class="course-item pb-3 border-bottom">
                  <div class="d-flex justify-content-between align-items-center">
                     <span class="course-name">Sire 2.0</span>
                     <a href="assets/frontend/img/courses_pdf.pdf" class="btn btn-sm btn-outline-primary" download>
                        <i class="fas fa-file-pdf me-1"></i> PDF
                     </a>
                  </div>
               </li>
               <li class="course-item pb-3 border-bottom">
                  <div class="d-flex justify-content-between align-items-center">
                     <span class="course-name">Auxiliary diesel engine maintenance course</span>
                     <a href="assets/frontend/img/courses_pdf.pdf" class="btn btn-sm btn-outline-primary" download>
                        <i class="fas fa-file-pdf me-1"></i> PDF
                     </a>
                  </div>
               </li>
               <li class="course-item pb-3 border-bottom">
                  <div class="d-flex justify-content-between align-items-center">
                     <span class="course-name">Chief engineer command course</span>
                     <a href="assets/frontend/img/courses_pdf.pdf" class="btn btn-sm btn-outline-primary" download>
                        <i class="fas fa-file-pdf me-1"></i> PDF
                     </a>
                  </div>
               </li>
               <li class="course-item pb-3 border-bottom">
                  <div class="d-flex justify-content-between align-items-center">
                     <span class="course-name">Ship security officer</span>
                     <a href="assets/frontend/img/courses_pdf.pdf" class="btn btn-sm btn-outline-primary" download>
                        <i class="fas fa-file-pdf me-1"></i> PDF
                     </a>
                  </div>
               </li>
               <li class="course-item pb-3 border-bottom">
                  <div class="d-flex justify-content-between align-items-center">
                     <span class="course-name">Gender sensitization course</span>
                     <a href="assets/frontend/img/courses_pdf.pdf" class="btn btn-sm btn-outline-primary" download>
                        <i class="fas fa-file-pdf me-1"></i> PDF
                     </a>
                  </div>
               </li>
               <li class="course-item pb-3 border-bottom">
                  <div class="d-flex justify-content-between align-items-center">
                     <span class="course-name">Engine room simulator refresher and engine room team resource management</span>
                     <a href="assets/frontend/img/courses_pdf.pdf" class="btn btn-sm btn-outline-primary" download>
                        <i class="fas fa-file-pdf me-1"></i> PDF
                     </a>
                  </div>
               </li>
               <li class="course-item pb-3 border-bottom">
                  <div class="d-flex justify-content-between align-items-center">
                     <span class="course-name">Tanker cargo operation</span>
                     <a href="assets/frontend/img/courses_pdf.pdf" class="btn btn-sm btn-outline-primary" download>
                        <i class="fas fa-file-pdf me-1"></i> PDF
                     </a>
                  </div>
               </li>
               <li class="course-item pb-3 border-bottom">
                  <div class="d-flex justify-content-between align-items-center">
                     <span class="course-name">Onboard seafarer's assessment</span>
                     <a href="assets/frontend/img/courses_pdf.pdf" class="btn btn-sm btn-outline-primary" download>
                        <i class="fas fa-file-pdf me-1"></i> PDF
                     </a>
                  </div>
               </li>
               <li class="course-item pb-3 border-bottom">
                  <div class="d-flex justify-content-between align-items-center">
                     <span class="course-name">Hull Structure Inspection Course</span>
                     <a href="assets/frontend/img/courses_pdf.pdf" class="btn btn-sm btn-outline-primary" download>
                        <i class="fas fa-file-pdf me-1"></i> PDF
                     </a>
                  </div>
               </li>
               <li class="course-item pb-3 border-bottom">
                  <div class="d-flex justify-content-between align-items-center">
                     <span class="course-name">ME - GI course</span>
                     <a href="assets/frontend/img/courses_pdf.pdf" class="btn btn-sm btn-outline-primary" download>
                        <i class="fas fa-file-pdf me-1"></i> PDF
                     </a>
                  </div>
               </li>
               <li class="course-item pb-3 border-bottom">
                  <div class="d-flex justify-content-between align-items-center">
                     <span class="course-name">Training Program for Gas Engineers</span>
                     <a href="assets/frontend/img/courses_pdf.pdf" class="btn btn-sm btn-outline-primary" download>
                        <i class="fas fa-file-pdf me-1"></i> PDF
                     </a>
                  </div>
               </li>
               <li class="course-item mb-3 border-bottom">
                  <div class="d-flex justify-content-between align-items-center">
                     <span class="course-name">CII Rating Training</span>
                     <a href="assets/frontend/img/courses_pdf.pdf" class="btn btn-sm btn-outline-primary" download>
                        <i class="fas fa-file-pdf me-1"></i> PDF
                     </a>
                  </div>
               </li>
            </ul>
         </div>
      </div>
   </div>
</section>

<!-- Offline/In-Person Courses Section -->
<section id="offline-course" class="courses_section pb-5 pt-5">
   <div class="container">
      <div class="row">
         <div class="col-12">
            <h2 class="robot_slab text_color mb-4">OFFLINE COURSE</h2>
            <ul class="course-list list-unstyled">
               <li class="course-item pb-3 border-bottom">
                  <div class="d-flex justify-content-between align-items-center">
                     <span class="course-name">Framo hydraulic cargo pumping system course</span>
                     <a href="assets/frontend/img/courses_pdf.pdf" class="btn btn-sm btn-outline-primary" download>
                        <i class="fas fa-file-pdf me-1"></i> PDF
                     </a>
                  </div>
               </li>
               <li class="course-item pb-3 border-bottom">
                  <div class="d-flex justify-content-between align-items-center">
                     <span class="course-name">Risk management and accident investigation course</span>
                     <a href="assets/frontend/img/courses_pdf.pdf" class="btn btn-sm btn-outline-primary" download>
                        <i class="fas fa-file-pdf me-1"></i> PDF
                     </a>
                  </div>
               </li>
               <li class="course-item pb-3 border-bottom">
                  <div class="d-flex justify-content-between align-items-center">
                     <span class="course-name">Chief engineer command course</span>
                     <a href="assets/frontend/img/courses_pdf.pdf" class="btn btn-sm btn-outline-primary" download>
                        <i class="fas fa-file-pdf me-1"></i> PDF
                     </a>
                  </div>
               </li>
               <li class="course-item pb-3 border-bottom">
                  <div class="d-flex justify-content-between align-items-center">
                     <span class="course-name">Gender sensitization course</span>
                     <a href="assets/frontend/img/courses_pdf.pdf" class="btn btn-sm btn-outline-primary" download>
                        <i class="fas fa-file-pdf me-1"></i> PDF
                     </a>
                  </div>
               </li>
               <li class="course-item pb-3 border-bottom">
                  <div class="d-flex justify-content-between align-items-center">
                     <span class="course-name">Mental health for seafarers course</span>
                     <a href="assets/frontend/img/courses_pdf.pdf" class="btn btn-sm btn-outline-primary" download>
                        <i class="fas fa-file-pdf me-1"></i> PDF
                     </a>
                  </div>
               </li>
               <li class="course-item pb-3 border-bottom">
                  <div class="d-flex justify-content-between align-items-center">
                     <span class="course-name">Engine room simulator refresher and engine room team resource management</span>
                     <a href="assets/frontend/img/courses_pdf.pdf" class="btn btn-sm btn-outline-primary" download>
                        <i class="fas fa-file-pdf me-1"></i> PDF
                     </a>
                  </div>
               </li>
               <li class="course-item pb-3 border-bottom">
                  <div class="d-flex justify-content-between align-items-center">
                     <span class="course-name">Basic hydraulic workshop</span>
                     <a href="assets/frontend/img/courses_pdf.pdf" class="btn btn-sm btn-outline-primary" download>
                        <i class="fas fa-file-pdf me-1"></i> PDF
                     </a>
                  </div>
               </li>
               <li class="course-item pb-3 border-bottom">
                  <div class="d-flex justify-content-between align-items-center">
                     <span class="course-name">Advanced hydraulics workshop</span>
                     <a href="assets/frontend/img/courses_pdf.pdf" class="btn btn-sm btn-outline-primary" download>
                        <i class="fas fa-file-pdf me-1"></i> PDF
                     </a>
                  </div>
               </li>
               <li class="course-item pb-3 border-bottom">
                  <div class="d-flex justify-content-between align-items-center">
                     <span class="course-name">Pneumatics and manoeuvring system course</span>
                     <a href="assets/frontend/img/courses_pdf.pdf" class="btn btn-sm btn-outline-primary" download>
                        <i class="fas fa-file-pdf me-1"></i> PDF
                     </a>
                  </div>
               </li>
               <li class="course-item pb-3 border-bottom">
                  <div class="d-flex justify-content-between align-items-center">
                     <span class="course-name">NK-O3 ballast water treatment system (BWTS) operations and troubleshooting course</span>
                     <a href="assets/frontend/img/courses_pdf.pdf" class="btn btn-sm btn-outline-primary" download>
                        <i class="fas fa-file-pdf me-1"></i> PDF
                     </a>
                  </div>
               </li>
               <li class="course-item pb-3 border-bottom">
                  <div class="d-flex justify-content-between align-items-center">
                     <span class="course-name">Samsung Purimar ballast water treatment system (BWTS) operations and troubleshooting course</span>
                     <a href="assets/frontend/img/courses_pdf.pdf" class="btn btn-sm btn-outline-primary" download>
                        <i class="fas fa-file-pdf me-1"></i> PDF
                     </a>
                  </div>
               </li>
               <li class="course-item pb-3 border-bottom">
                  <div class="d-flex justify-content-between align-items-center">
                     <span class="course-name">Hyundai HiBallast water treatment system (BWTS) operations and troubleshooting course</span>
                     <a href="assets/frontend/img/courses_pdf.pdf" class="btn btn-sm btn-outline-primary" download>
                        <i class="fas fa-file-pdf me-1"></i> PDF
                     </a>
                  </div>
               </li>
               <li class="course-item pb-3 border-bottom">
                  <div class="d-flex justify-content-between align-items-center">
                     <span class="course-name">Hull Structure Inspection Course</span>
                     <a href="assets/frontend/img/courses_pdf.pdf" class="btn btn-sm btn-outline-primary" download>
                        <i class="fas fa-file-pdf me-1"></i> PDF
                     </a>
                  </div>
               </li>
               <li class="course-item pb-3 border-bottom">
                  <div class="d-flex justify-content-between align-items-center">
                     <span class="course-name">CII Rating Training</span>
                     <a href="assets/frontend/img/courses_pdf.pdf" class="btn btn-sm btn-outline-primary" download>
                        <i class="fas fa-file-pdf me-1"></i> PDF
                     </a>
                  </div>
               </li>
            </ul>
         </div>
      </div>
   </div>
</section>
@endsection

