@extends('layouts.app')

@section('title', 'Knowledge Sources - ' . $domain->name)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center gap-4">
        <a href="{{ route('domains.manage', $domain) }}" class="btn btn-ghost btn-circle">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <div class="flex-1">
            <h1 class="text-3xl font-bold">Knowledge Sources</h1>
            <p class="text-base-content/60 mt-1">Managing sources for: <strong>{{ $domain->name }}</strong></p>
        </div>
        <a href="{{ route('domains.knowledge-sources.create', $domain) }}" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Add Knowledge Source
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="alert alert-success shadow-lg">
        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <!-- Knowledge Sources Table -->
    <div class="card bg-base-100 shadow-xl">
        <div class="card-body p-0">
            @if($knowledgeSources->count() > 0)
            <div class="overflow-x-auto">
                <table class="table table-zebra w-full">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($knowledgeSources as $source)
                        <tr id="knowledge-source-{{ $source->id }}">
                            <td class="font-medium">
                                {{ $source->name }}
                                <br>
                                <code class="text-xs badge badge-ghost">{{ $source->slug }}</code>
                            </td>
                            <td>
                                @if($source->type === 'codebase')
                                <span class="badge badge-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                                    </svg>
                                    Codebase
                                </span>
                                @elseif($source->type === 'database')
                                <span class="badge badge-secondary">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
                                    </svg>
                                    Database
                                </span>
                                @else
                                <span class="badge">{{ ucfirst($source->type) }}</span>
                                @endif
                            </td>
                            <td>
                                <div class="max-w-xs truncate">
                                    {{ $source->description ?? 'No description' }}
                                </div>
                            </td>
                            <td>
                                @if($source->is_active)
                                <span class="badge badge-success">Active</span>
                                @else
                                <span class="badge badge-ghost">Inactive</span>
                                @endif
                            </td>
                            <td>{{ $source->created_at->format('M d, Y') }}</td>
                            <td>
                                <div class="flex gap-2 justify-end">
                                    <a href="{{ route('domains.knowledge-sources.edit', [$domain, $source]) }}" class="btn btn-sm btn-warning" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <button
                                        hx-delete="{{ route('domains.knowledge-sources.destroy', [$domain, $source]) }}"
                                        hx-target="#knowledge-source-{{ $source->id }}"
                                        hx-swap="outerHTML"
                                        hx-confirm="Are you sure you want to delete this knowledge source?"
                                        class="btn btn-sm btn-error"
                                        title="Delete"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($knowledgeSources->hasPages())
            <div class="p-4 border-t border-base-300">
                {{ $knowledgeSources->links() }}
            </div>
            @endif
            @else
            <!-- Empty State -->
            <div class="text-center py-12">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-base-content/30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                <h3 class="mt-4 text-lg font-medium">No knowledge sources found</h3>
                <p class="mt-2 text-base-content/60">Get started by adding a codebase or database knowledge source.</p>
                <a href="{{ route('domains.knowledge-sources.create', $domain) }}" class="btn btn-primary mt-4">
                    Add Knowledge Source
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
