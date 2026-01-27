@extends('frontend.layouts.app')

@section('meta.title', 'Certificate: ' . ($certificate->certificate_no ?? 'Certificate'))
@section('meta.description', 'View your course completion certificate')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Certificate of Completion</h3>
                </div>
                <div class="card-body">
                    <div class="certificate-container bg-white p-5 rounded-3 shadow-sm border">
                        <div class="text-center mb-5">
                            <h2 class="text-uppercase fw-bold text-primary mb-3">Certificate of Completion</h2>
                            <p class="text-muted">This certificate is proudly presented to</p>
                        </div>

                        <div class="text-center mb-5">
                            <h1 class="display-4 fw-bold text-primary">
                                {{ ucwords($certificate->user->name) ?? 'Student Name' }}
                            </h1>
                        </div>

                        <div class="text-center mb-4">
                            <p class="lead">
                                For successfully completing the course:
                            </p>
                            <h3 class="fw-bold text-primary">
                                {{ $certificate->course->name ?? 'Course Name' }}
                            </h3>
                        </div>

                        <div class="text-center mb-4">
                            <p class="lead">
                                With quiz score: 
                                <span class="fw-bold">
                                    {{ $quizAttempt->obtained_marks ?? 0 }}/{{ $quizAttempt->total_marks ?? 0 }}
                                </span>
                            </p>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 text-center">
                                <p class="mb-0"><strong>Certificate Number:</strong></p>
                                <p class="fw-bold text-primary">{{ $certificate->certificate_no ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6 text-center">
                                <p class="mb-0"><strong>Date Issued:</strong></p>
                                <p class="fw-bold">
                                    @if($certificate->issued_at)
                                        {{ is_string($certificate->issued_at) ? date('F j, Y', strtotime($certificate->issued_at)) : $certificate->issued_at->format('F j, Y') }}
                                    @else
                                        N/A
                                    @endif
                                </p>
                            </div>
                        </div>

                        <div class="text-center mt-5">
                            <div class="mb-4">
                                <img src="{{ asset('assets/backend/img/logo.png') }}" 
                                     alt="Institution Logo" 
                                     class="certificate-logo" 
                                     style="max-height: 80px;">
                            </div>
                            <p class="text-muted">
                                This certificate is awarded for demonstrating excellence in learning and commitment to personal growth.
                            </p>
                        </div>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-5">
                        <button onclick="window.print()" class="btn btn-primary me-md-2">
                            <i class="fas fa-print me-2"></i>Print Certificate
                        </button>
                        <a href="{{ route('auth.enrolled-courses') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Courses
                        </a>
                    </div>                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .certificate-container {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border: 2px solid #dee2e6;
        position: relative;
    }
    
    .certificate-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-image: 
            repeating-linear-gradient(45deg, transparent, transparent 35px, rgba(0,0,0,0.05) 35px, rgba(0,0,0,0.05) 70px);
        opacity: 0.3;
        z-index: 0;
    }
    
    .certificate-container > * {
        position: relative;
        z-index: 1;
    }
    
    @media print {

        /* Hide everything */
        body * {
            visibility: hidden;
        }

        /* Show only certificate */
        .certificate-container,
        .certificate-container * {
            visibility: visible;
        }

        /* Position certificate properly */
        .certificate-container {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            background: white !important;
            border: none !important;
            box-shadow: none !important;
        }

        /* Remove watermark / overlay */
        .certificate-container::before {
            display: none !important;
        }

        /* Page settings */
        @page {
            size: A4;
            margin: 20mm;
        }
    }

</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add any certificate-specific JavaScript here
    });
</script>
@endsection