@extends('layouts.app')
@section('content')
<div class="container">
    <a href="{{ route('projects', app()->getLocale()) }}" class="btn btn-outline-light mb-4">← {{ __('pages.back') }}</a>

    <div class="row gy-5">
        <div class="col-lg-8">
            <h1 class="fw-bold mb-3">{{ $project->title }}</h1>
            <p class="fs-5 mb-4">{{ $project->description }}</p>

            <h5 class="fw-semibold mb-2">Tech Stack</h5>
            <div class="mb-4">
                @foreach($project->tech as $t)
                    <span class="badge bg-primary-subtle text-primary me-1">{{ $t }}</span>
                @endforeach
            </div>

            <div class="d-flex gap-3">
                @if($project->live_url)
                    <a href="{{ $project->live_url }}" target="_blank" class="btn btn-primary">Live Demo</a>
                @endif
                @if($project->github_url)
                    <a href="{{ $project->github_url }}" target="_blank" class="btn btn-dark">GitHub</a>
                @endif
            </div>
        </div>
        <div class="col-lg-4">
            @if($project->thumbnail_url)
                <img src="{{ $project->thumbnail_url }}" alt="{{ $project->title }}" class="img-fluid rounded">
            @endif
        </div>
    </div>

    @if(count($project->image_urls) > 0)
    <div class="mt-5">
        <h3 class="fw-bold mb-4">Project Gallery</h3>
        <div class="row g-3">
            @foreach($project->image_urls as $imageUrl)
            <div class="col-md-4">
                <img src="{{ $imageUrl }}" alt="Project Image" class="img-fluid rounded">
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection