@extends('frontend.layouts.profile')

@section('meta.title', 'Enrolled Courses')
@section('meta.description', 'View your enrolled courses')

@php
    $pageTitle = 'Enrolled Courses';
@endphp

@section('profile-content')
<div class="bg-light p-4 p-md-5 rounded-3 shadow-sm">
    <h3 class="fw-bold mb-4 robot_slab">My Enrolled Courses</h3>

    @if($enrolledCourses->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover" id="enrolledCoursesTable">
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Name</th>
                        <th>Enrolled Date</th>
                        <th>Validity</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($enrolledCourses as $enrolment)
                        <tr>
                            <td data-order="{{ $enrolment->id }}">
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

        <div class="mt-4">
            {{-- {{ $enrolledCourses->links() }} --}}
        </div>
    @else
        <div class="text-center py-5">
            <i class="fas fa-graduation-cap fa-3x text-muted mb-3"></i>
            <p class="text-muted">You haven't enrolled in any courses yet.</p>
            <a href="" class="btn btn-primary mt-3">Browse Courses</a>
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#enrolledCoursesTable').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "responsive": true,
            pageLength: 25,
            "order": [[0, "asc"]]
        });
    });
</script>
@endsection

