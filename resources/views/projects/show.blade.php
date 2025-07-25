@extends('layouts.app')

@section('content')
<section class="py-5">
    <div class="container">
        <a href="{{ route('projects', app()->getLocale()) }}" class="btn btn-outline-light mb-4">← {{ __('pages.back') }}</a>

        <div class="row gy-5">
            <div class="col-lg-8">
                <h1 class="fw-bold mb-3">{{ $project->title[app()->getLocale()] }}</h1>
                <p class="fs-5 mb-4">{{ $project->description[app()->getLocale()] }}</p>

                <h5 class="fw-semibold mb-2">Tech Stack</h5>
                <div class="mb-4">
                    @foreach($project->tech as $t)
                        <span class="badge bg-primary-subtle text-primary me-1">{{ $t }}</span>
                    @endforeach
                </div>

                <div class="d-flex gap-3">
                    <a href="{{ $project->live_url }}" target="_blank" class="btn btn-primary">Live Demo</a>
                    <a href="{{ $project->github_url }}" target="_blank" class="btn btn-outline-light">GitHub</a>
                </div>
            </div>
            <div class="col-lg-4">
                <img src="{{ asset($project->thumbnail) }}" class="img-fluid rounded-4 shadow" alt="{{ $project->title[app()->getLocale()] }}">
            </div>
        </div>
    </div>
</section>
@endsection