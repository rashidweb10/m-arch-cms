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
            <h2 class="robot_slab text_color mb-4 text-uppercase">
               <i class="fa-solid fa-laptop me-2"></i> {{ $onlineCategory->name ?? 'ONLINE COURSE' }}
            </h2>
            <ul class="course-list list-unstyled">
               @if(isset($onlineCategory) && $onlineCategory->courses->count() > 0)
                  @foreach($onlineCategory->courses as $course)
                     <li class="course-item pb-3 border-bottom">
                        <div class="d-flex align-items-center">
                           <span class="course-bullet me-3"></span>
                           <span class="course-name">{{ $course->name }}</span>
                           @if($course->brochure)
                           <a href="{{ uploaded_asset($course->brochure) }}" class="btn btn-sm btn-outline-primary ms-2" download>
                              <i class="fas fa-file-pdf"></i>
                           </a>
                           @endif
                        </div>
                     </li>
                  @endforeach
               @else
                  <li class="course-item pb-3">
                     <div class="d-flex align-items-center">
                        <span class="course-bullet me-3"></span>
                        <span class="course-name">No online courses available</span>
                     </div>
                  </li>
               @endif
            </ul>
         </div>

         <!-- Offline Courses Section -->
         <div class="col-lg-6 ps-lg-5" id="offline-course">
            <h2 class="robot_slab text_color mb-4 text-uppercase">
               <i class="fa-solid fa-chalkboard me-2"></i> {{ $offlineCategory->name ?? 'OFFLINE COURSE' }}
            </h2>
            <ul class="course-list list-unstyled">
               @if(isset($offlineCategory) && $offlineCategory->courses->count() > 0)
                  @foreach($offlineCategory->courses as $course)
                     <li class="course-item pb-3 border-bottom">
                        <div class="d-flex align-items-center">
                           <span class="course-bullet me-3"></span>
                           <span class="course-name">{{ $course->name }}</span>
                           <a href="assets/frontend/img/courses_pdf.pdf" class="btn btn-sm btn-outline-primary ms-2" download>
                              <i class="fas fa-file-pdf"></i>
                           </a>
                        </div>
                     </li>
                  @endforeach
               @else
                  <li class="course-item pb-3">
                     <div class="d-flex align-items-center">
                        <span class="course-bullet me-3"></span>
                        <span class="course-name">No offline courses available</span>
                     </div>
                  </li>
               @endif
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
                        @if(isset($onlineCategory) && $onlineCategory->courses->count() > 0)
                           @foreach($onlineCategory->courses as $course)
                              <option value="{{ $course->name }}">{{ $course->name }}</option>
                           @endforeach
                        @else
                           <option value="">No online courses available</option>
                        @endif
                     </optgroup>
                     <optgroup label="Offline Courses">
                        @if(isset($offlineCategory) && $offlineCategory->courses->count() > 0)
                           @foreach($offlineCategory->courses as $course)
                              <option value="{{ $course->name }}">{{ $course->name }}</option>
                           @endforeach
                        @else
                           <option value="">No offline courses available</option>
                        @endif
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
