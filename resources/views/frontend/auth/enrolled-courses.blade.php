@extends('frontend.layouts.profile')

@section('meta.title', 'Enrolled Courses')
@section('meta.description', 'View your enrolled courses')

@php
    $pageTitle = 'Enrolled Courses';
@endphp

@section('profile-content')
<div class="bg-light p-4 p-md-5 rounded-3 shadow-sm">
    <h3 class="fw-bold mb-4 robot_slab">My Enrolled Courses</h3>
    
    <!-- Search Filter -->
    <div class="row mb-4">
        <div class="col-md-8">
            <form method="GET" action="{{ route('auth.enrolled-courses') }}">
                <div class="row g-2 align-items-center">
                    
                    <div class="col-md-7 col-12">
                        <input type="text" name="search"
                            class="form-control"
                            placeholder="Search by course or category name..."
                            value="{{ request()->get('search') }}">
                    </div>

                    <div class="col-md-3 col-6">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search me-1"></i> Search
                        </button>
                    </div>

                    @if(request()->get('search'))
                    <div class="col-md-2 col-6">
                        <a href="{{ route('auth.enrolled-courses') }}" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-times me-1"></i> Clear
                        </a>
                    </div>
                    @endif

                </div>
            </form>
        </div>
    </div>

    @if($enrolledCourses->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Category</th>
                        <th>Name</th>
                        <th>Enrolled Date</th>
                        <th>Validity</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($enrolledCourses as $index => $enrolment)
                        <tr>
                            <td>{{ $enrolledCourses->firstItem() + $index }}</td>
                            <td>
                                {{ $enrolment->course->category->name ?? 'N/A' }}
                            </td>
                            <td>
                                <strong>{{ $enrolment->course->name ?? 'N/A' }}</strong>
                            </td>
                            <td>
                                {{ formatDate($enrolment->created_at) }}
                            </td>
                            <td>
                                @if($enrolment->validity)
                                    {{ formatDate($enrolment->validity) }}
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $currentDate = \Carbon\Carbon::now();
                                    $validityDate = $enrolment->validity ? \Carbon\Carbon::parse($enrolment->validity) : null;
                                    $isExpired = $validityDate && $currentDate->greaterThan($validityDate);
                                @endphp
                                  
                                @if($isExpired)
                                    <span class="text-danger fw-bold">Expired</span>
                                @else
                                    <a href="{{ route('auth.enrolled-courses.show', $enrolment->course_id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye me-1"></i>View
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Laravel Pagination -->
        <div class="mt-4">
            {{ $enrolledCourses->appends(request()->input())->links() }}
        </div>
    @else
        <div class="text-center py-5">
            <i class="fas fa-graduation-cap fa-3x text-muted mb-3"></i>
            <p class="text-muted">No courses found.</p>
            {{-- <a href="" class="btn btn-primary mt-3">Browse Courses</a> --}}
        </div>
    @endif
</div>
@endsection

@section('scripts')
<!-- No DataTable script needed - using Laravel pagination -->
@endsection

