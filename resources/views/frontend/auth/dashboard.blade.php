@extends('frontend.layouts.profile')

@section('meta.title', 'Dashboard')
@section('meta.description', 'Your enrolled categories and earned certificates')

@php
    $pageTitle = 'Dashboard';
@endphp

@section('profile-content')
<div class="student-dashboard">
    <section class="dashboard-welcome mb-4">
        <div>
            <p class="dashboard-eyebrow mb-2">STUDENT DASHBOARD</p>
            <h2 class="robot_slab mb-2">Welcome, {{ $user->name }}</h2>
            <p class="mb-0">Your training progress and achievements at a glance.</p>
        </div>
        <a href="{{ route('auth.enrolled-categories') }}" class="btn dashboard-primary-btn">
            <i class="fas fa-book-open me-2" aria-hidden="true"></i>My courses
        </a>
    </section>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-3 mb-4">
        <div class="col-sm-6">
            <div class="dashboard-stat h-100">
                <span class="dashboard-stat-icon courses-icon"><i class="fas fa-graduation-cap" aria-hidden="true"></i></span>
                <div>
                    <div class="dashboard-stat-value">{{ $activeCategoryCount }}</div>
                    <div class="dashboard-stat-label">Active courses</div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="dashboard-stat h-100">
                <span class="dashboard-stat-icon certificates-icon"><i class="fas fa-certificate" aria-hidden="true"></i></span>
                <div>
                    <div class="dashboard-stat-value">{{ $certificateCount }}</div>
                    <div class="dashboard-stat-label">Certificates earned</div>
                </div>
            </div>
        </div>
    </div>

    <section class="dashboard-account-tip mt-4">
        <div class="dashboard-tip-icon"><i class="fas fa-user-check" aria-hidden="true"></i></div>
        <div>
            <h4 class="mb-1">Keep your account up to date</h4>
            <p class="mb-0">Make sure your contact details are current so you don’t miss important course updates.</p>
        </div>
        <a href="{{ route('auth.profile') }}" class="dashboard-view-all ms-auto">Edit profile <i class="fas fa-arrow-right ms-1" aria-hidden="true"></i></a>
    </section>
</div>

<style>
    .student-dashboard {
        --dashboard-blue: #147eae;
        --dashboard-ink: #18364a;
        --dashboard-muted: #6c7b86;
    }

    .dashboard-welcome {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 24px;
        padding: 30px;
        border-radius: 16px;
        color: #fff;
        background: linear-gradient(120deg, #147eae, #0d547c);
        box-shadow: 0 10px 24px rgba(13, 84, 124, .16);
    }

    .dashboard-welcome h2 {
        color: #fff;
        font-size: clamp(1.45rem, 3vw, 2rem);
    }

    .dashboard-welcome p:not(.dashboard-eyebrow) {
        color: rgba(255, 255, 255, .82);
    }

    .dashboard-eyebrow {
        color: #b9e7fa;
        font-size: .72rem;
        font-weight: 700;
        letter-spacing: .13em;
    }

    .dashboard-primary-btn {
        color: #fff;
        border: 0;
        background: var(--dashboard-blue);
        font-weight: 600;
        white-space: nowrap;
    }

    .dashboard-welcome .dashboard-primary-btn {
        color: var(--dashboard-blue);
        background: #fff;
    }

    .dashboard-primary-btn:hover,
    .dashboard-welcome .dashboard-primary-btn:hover {
        color: #fff;
        background: #105f86;
    }

    .dashboard-stat {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 19px;
        background: #fff;
        border: 1px solid #e9eef1;
        border-radius: 12px;
        box-shadow: 0 4px 14px rgba(24, 54, 74, .04);
    }

    .dashboard-stat-icon,
    .dashboard-tip-icon {
        display: inline-flex;
        flex: 0 0 auto;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
    }

    .dashboard-stat-icon {
        width: 48px;
        height: 48px;
        font-size: 1.2rem;
    }

    .courses-icon { color: #147eae; background: #e8f5fb; }
    .certificates-icon { color: #a66b10; background: #fff5df; }

    .dashboard-stat-value {
        color: var(--dashboard-ink);
        font-size: 1.5rem;
        font-weight: 700;
        line-height: 1.1;
    }

    .dashboard-stat-label {
        margin-top: 4px;
        color: var(--dashboard-muted);
        font-size: .88rem;
    }

    .dashboard-account-tip {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 16px 18px;
        background: #f1f8fb;
        border-radius: 12px;
    }

    .dashboard-tip-icon {
        width: 42px;
        height: 42px;
        color: var(--dashboard-blue);
        background: #fff;
    }

    .dashboard-account-tip h4 {
        color: var(--dashboard-ink);
        font-size: .95rem;
        font-weight: 700;
    }

    .dashboard-account-tip p {
        color: var(--dashboard-muted);
        font-size: .84rem;
    }

    .dashboard-view-all {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 4px;
        flex: 0 0 auto;
        padding: 10px 14px;
        color: var(--dashboard-blue);
        background: #fff;
        border: 1px solid #d7eaf3;
        border-radius: 8px;
        font-size: .9rem;
        font-weight: 600;
        line-height: 1.25;
        text-decoration: none;
        white-space: nowrap;
        transition: color .2s ease, background-color .2s ease, border-color .2s ease;
    }

    .dashboard-view-all:hover,
    .dashboard-view-all:focus-visible {
        color: #fff;
        background: var(--dashboard-blue);
        border-color: var(--dashboard-blue);
        text-decoration: none;
    }

    @media (max-width: 767.98px) {
        .dashboard-welcome {
            align-items: flex-start;
            flex-direction: column;
            padding: 24px;
        }

        .dashboard-account-tip {
            align-items: flex-start;
            flex-wrap: wrap;
        }

        .dashboard-account-tip .dashboard-view-all {
            margin-left: 56px !important;
        }
    }
</style>
@endsection
