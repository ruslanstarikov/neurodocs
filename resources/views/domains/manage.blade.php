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

    <!-- Placeholder for Knowledge Sources Management -->
    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <h2 class="card-title">Knowledge Sources</h2>
            <div class="text-center py-12">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-base-content/30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                <h3 class="mt-4 text-lg font-medium">Knowledge Sources Management</h3>
                <p class="mt-2 text-base-content/60">This feature will be available in the next phase.</p>
                <p class="mt-1 text-sm text-base-content/40">You'll be able to attach and manage knowledge sources for this domain.</p>
            </div>
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
