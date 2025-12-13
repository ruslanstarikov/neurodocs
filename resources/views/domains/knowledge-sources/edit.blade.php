@extends('layouts.app')

@section('title', 'Edit Knowledge Source')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center gap-4">
        <a href="{{ route('domains.knowledge-sources.index', $domain) }}" class="btn btn-ghost btn-circle">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <div>
            <h1 class="text-3xl font-bold">Edit Knowledge Source</h1>
            <p class="text-base-content/60 mt-1">{{ $knowledgeSource->name }}</p>
        </div>
    </div>

    <!-- Form Card -->
    <div class="card bg-base-100 shadow-xl max-w-4xl">
        <div class="card-body">
            <form action="{{ route('domains.knowledge-sources.update', [$domain, $knowledgeSource]) }}" method="POST" id="ks-form">
                @csrf
                @method('PUT')

                @include('domains.knowledge-sources.partials.form', [
                    'isEdit' => true,
                    'knowledgeSource' => $knowledgeSource
                ])

                <!-- Meta Info -->
                <div class="alert alert-info mt-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div class="text-sm">
                        <p><strong>Created:</strong> {{ $knowledgeSource->created_at->format('M d, Y g:i A') }}</p>
                        <p><strong>Last Updated:</strong> {{ $knowledgeSource->updated_at->format('M d, Y g:i A') }}</p>
                    </div>
                </div>

                <!-- Actions -->
                <div class="card-actions justify-end mt-6 pt-6 border-t border-base-300">
                    <a href="{{ route('domains.knowledge-sources.index', $domain) }}" class="btn btn-ghost">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Update Knowledge Source
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
