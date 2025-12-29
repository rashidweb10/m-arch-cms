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
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Course Name</th>
                        <th>Category</th>
                        <th>Enrolled Date</th>
                        <th>Validity</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($enrolledCourses as $enrolment)
                        <tr>
                            <td>
                                <strong>{{ $enrolment->course->name ?? 'N/A' }}</strong>
                            </td>
                            <td>
                                {{ $enrolment->course->category->name ?? 'N/A' }}
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
                                <a href="{{ route('auth.enrolled-courses.show', $enrolment->course_id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye me-1"></i>View
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $enrolledCourses->links() }}
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

