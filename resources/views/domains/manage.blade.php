@extends('layouts.app')

@section('title', 'Manage Domain')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center gap-4">
        <a href="{{ route('domains.index') }}" class="btn btn-ghost btn-circle">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <div>
            <h1 class="text-3xl font-bold">Manage: {{ $domain->name }}</h1>
            <p class="text-base-content/60 mt-1">Configure knowledge sources and settings</p>
        </div>
    </div>

    <!-- Domain Info Card -->
    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <h2 class="card-title">Domain Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <div>
                    <p class="text-sm text-base-content/60">Name</p>
                    <p class="font-medium">{{ $domain->name }}</p>
                </div>
                <div>
                    <p class="text-sm text-base-content/60">Slug</p>
                    <p class="font-medium"><code class="badge badge-ghost">{{ $domain->slug }}</code></p>
                </div>
                <div>
                    <p class="text-sm text-base-content/60">Status</p>
                    <p class="font-medium">
                        @if($domain->is_active)
                        <span class="badge badge-success">Active</span>
                        @else
                        <span class="badge badge-ghost">Inactive</span>
                        @endif
                    </p>
                </div>
                <div>
                    <p class="text-sm text-base-content/60">Created</p>
                    <p class="font-medium">{{ $domain->created_at->format('M d, Y') }}</p>
                </div>
            </div>
            @if($domain->description)
            <div class="mt-4">
                <p class="text-sm text-base-content/60">Description</p>
                <p class="mt-1">{{ $domain->description }}</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Knowledge Sources Management -->
    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <div class="flex justify-between items-center mb-4">
                <h2 class="card-title">Knowledge Sources</h2>
                <a href="{{ route('domains.knowledge-sources.index', $domain) }}" class="btn btn-primary btn-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Manage Sources
                </a>
            </div>

            @php
                $sourcesCount = $domain->knowledgeSources()->count();
                $recentSources = $domain->knowledgeSources()->latest()->limit(3)->get();
            @endphp

            @if($sourcesCount > 0)
            <div class="space-y-3">
                @foreach($recentSources as $source)
                <div class="flex items-center justify-between p-3 bg-base-200 rounded-lg">
                    <div class="flex items-center gap-3">
                        @if($source->type === 'codebase')
                        <div class="badge badge-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                            </svg>
                            Codebase
                        </div>
                        @else
                        <div class="badge badge-secondary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
                            </svg>
                            Database
                        </div>
                        @endif
                        <div>
                            <p class="font-medium">{{ $source->name }}</p>
                            <p class="text-xs text-base-content/60">{{ Str::limit($source->description, 50) ?: 'No description' }}</p>
                        </div>
                    </div>
                    <span class="badge {{ $source->is_active ? 'badge-success' : 'badge-ghost' }}">
                        {{ $source->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
                @endforeach

                @if($sourcesCount > 3)
                <p class="text-sm text-base-content/60 text-center pt-2">
                    And {{ $sourcesCount - 3 }} more source{{ $sourcesCount - 3 > 1 ? 's' : '' }}...
                </p>
                @endif
            </div>
            @else
            <div class="text-center py-8">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-base-content/30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                <p class="mt-3 text-base-content/60">No knowledge sources configured yet</p>
                <a href="{{ route('domains.knowledge-sources.index', $domain) }}" class="btn btn-sm btn-primary mt-3">
                    Add Your First Source
                </a>
            </div>
            @endif
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="flex gap-4">
        <a href="{{ route('domains.edit', $domain) }}" class="btn btn-warning">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            Edit Domain
        </a>
        <a href="{{ route('domains.index') }}" class="btn btn-ghost">Back to List</a>
    </div>
</div>
@endsection
