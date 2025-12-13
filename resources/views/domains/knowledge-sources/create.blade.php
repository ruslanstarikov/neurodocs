@extends('layouts.app')

@section('title', 'Add Knowledge Source')

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
            <h1 class="text-3xl font-bold">Add Knowledge Source</h1>
            <p class="text-base-content/60 mt-1">For domain: <strong>{{ $domain->name }}</strong></p>
        </div>
    </div>

    <!-- Form Card -->
    <div class="card bg-base-100 shadow-xl max-w-4xl">
        <div class="card-body">
            <form action="{{ route('domains.knowledge-sources.store', $domain) }}" method="POST" id="ks-form">
                @csrf

                @include('domains.knowledge-sources.partials.form', ['isEdit' => false])

                <!-- Actions -->
                <div class="card-actions justify-end mt-6 pt-6 border-t border-base-300">
                    <a href="{{ route('domains.knowledge-sources.index', $domain) }}" class="btn btn-ghost">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Create Knowledge Source
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
