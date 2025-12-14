@extends('frontend.layouts.app')

@section('meta.title', 'Contact Us')
@section('meta.description', 'Contact Us')

@section('content')

@include('frontend.partials.breadcrumb', ['title' => "Faculties"])

<section class="py-5 px-3 position-relative">
   <div class="container">
      <!-- Header -->
      <div class="text-center mb-5">
         <h2 class="fw-bold display-5 text-primary mb-3 robot_slab " style="background: linear-gradient(90deg, #0077b6, #00b4d8); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
            Executive Faculties
         </h2>
         <div class="section-divider mb-3"></div>
         <p class="text-muted mx-auto" style="max-width: 700px;">
            Meet our distinguished faculty members who bring decades of maritime expertise and educational excellence to our institution.
         </p>
      </div>
      <!-- Faculty Grid -->
      <div class="row g-5">
         <!-- Faculty 1 -->
         <div class="col-lg-6">
            <div class="card faculty-card p-4">
               <div class="d-flex align-items-start gap-3">
                  <img src="assets/frontend/img/archana.jpg" alt="Ms Archana Saxena Sangal" class="faculty-image" />
                  <div>
                     <h5 class="faculty-name mb-1 robot_slab ">Ms Archana Saxena Sangal</h5>
                     <p class="faculty-description">
                        (Director of MarinArch, CE, Ex Technical Superintendent)
                     </p>
                  </div>
               </div>
            </div>
         </div>
         <!-- Faculty 2 -->
         <div class="col-lg-6">
            <div class="card faculty-card p-4">
               <div class="d-flex align-items-start gap-3">
                  <img src="assets/frontend/img/vivek.jpg" alt="Mr Vivek Sangal" class="faculty-image" />
                  <div>
                     <h5 class="faculty-name mb-1 robot_slab ">Mr Vivek Sangal</h5>
                     <p class="faculty-description">
                        Chief Engineer, Sailing experience of 18 years with 6 years as "Chief Engineer"
                     </p>
                  </div>
               </div>
            </div>
         </div>
         <!-- Faculty 3 -->
         <div class="col-lg-6">
            <div class="card faculty-card p-4">
               <div class="d-flex align-items-start gap-3">
                  <img src="assets/frontend/img/brijendra.jpg" alt="Dr. Brijendra Kumar Saxena" class="faculty-image" />
                  <div>
                     <h5 class="faculty-name mb-1 robot_slab ">Dr. Brijendra Kumar Saxena</h5>
                     <p class="faculty-description">
                        Former Principal of "Tolani Maritime Institute" and past President of IMEI. He has MSc from WMU, Sweden and Insurance Law and Finance. He has 50+ years of experience in all areas of shipping.
                     </p>
                  </div>
               </div>
            </div>
         </div>
         <!-- Faculty 4 -->
         <div class="col-lg-6">
            <div class="card faculty-card p-4">
               <div class="d-flex align-items-start gap-3">
                  <img src="assets/frontend/img/pravendra.jpg" alt="Mr Pravendra Singh" class="faculty-image" />
                  <div>
                     <h5 class="faculty-name mb-1 robot_slab ">Mr Pravendra Singh</h5>
                     <p class="faculty-description">
                        Vessel Manager, Sailing experience 15 years with 4 years as "Chief Engineer"
                     </p>
                  </div>
               </div>
            </div>
         </div>
         <!-- Faculty 5 -->
         <div class="col-lg-6">
            <div class="card faculty-card p-4">
               <div class="d-flex align-items-start gap-3">
                  <img src="assets/frontend/img/basu.jpg" alt="Mr I. K. Basu" class="faculty-image" />
                  <div>
                     <h5 class="faculty-name mb-1 robot_slab ">Mr I. K. Basu</h5>
                     <p class="faculty-description">
                        He was graduated in Electrical Engineering. He is ex Chief Engineer and has a vast experience at sea. He also worked as a faculty member at esteemed Tolani Maritime Institute for about 15 yrs.
                     </p>
                  </div>
               </div>
            </div>
         </div>
         <!-- Faculty 6 -->
         <div class="col-lg-6">
            <div class="card faculty-card p-4">
               <div class="d-flex align-items-start gap-3">
                  <img src="assets/frontend/img/vishwanath.jpg" alt="Capt. Vishwanath Shenoy" class="faculty-image" />
                  <div>
                     <h5 class="faculty-name mb-1 robot_slab ">Capt. Vishwanath Shenoy</h5>
                     <p class="faculty-description">
                        He is a Master Mariner with Oil tanker background. He worked as the Marine Superintendent. He has also an experience of B. Sc. Nautical Science Faculty.
                     </p>
                  </div>
               </div>
            </div>
         </div>
         <!-- Faculty 7 (New) -->
         <div class="col-lg-6">
            <div class="card faculty-card p-4">
               <div class="d-flex align-items-start gap-3">
                  <img src="assets/frontend/img/mahajan.jpg" alt="Mr Arun O Mahajan" class="faculty-image" />
                  <div>
                     <h5 class="faculty-name mb-1 robot_slab ">Mr. Arun O Mahajan</h5>
                     <ul class="faculty-description">
                        <li class="faculty-description">BE (Mechanical)</li>
                        <li class="faculty-description" >M Tech (Thermal Power Engg.)</li>
                        <li class="faculty-description">MEO Class I (Motor)</li>
                        <li class="faculty-description">15 Years Sailing Experience at Various Ranks,
                           Including CE Rank
                        </li>
                        <li class="faculty-description">14 Years Teaching Experience, Worked as Senior
                           Associate Professor (Marine Engeering) at
                           Tolani Maritime Institute.
                        </li>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>

@endsection

