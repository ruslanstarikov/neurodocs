@extends('layouts.app')

@section('title', 'Create Domain')

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
            <h1 class="text-3xl font-bold">Create Domain</h1>
            <p class="text-base-content/60 mt-1">Add a new domain to your application</p>
        </div>
    </div>

    <!-- Form Card -->
    <div class="card bg-base-100 shadow-xl max-w-2xl">
        <div class="card-body">
            <form action="{{ route('domains.store') }}" method="POST">
                @csrf

                <!-- Name -->
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text font-medium">Name <span class="text-error">*</span></span>
                    </label>
                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Enter domain name"
                        class="input input-bordered w-full @error('name') input-error @enderror"
                        required
                    />
                    @error('name')
                    <label class="label">
                        <span class="label-text-alt text-error">{{ $message }}</span>
                    </label>
                    @enderror
                    <label class="label">
                        <span class="label-text-alt">A unique name for this domain</span>
                    </label>
                </div>

                <!-- Description -->
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text font-medium">Description</span>
                    </label>
                    <textarea
                        name="description"
                        rows="4"
                        placeholder="Enter domain description"
                        class="textarea textarea-bordered w-full @error('description') textarea-error @enderror"
                    >{{ old('description') }}</textarea>
                    @error('description')
                    <label class="label">
                        <span class="label-text-alt text-error">{{ $message }}</span>
                    </label>
                    @enderror
                    <label class="label">
                        <span class="label-text-alt">Optional description for this domain</span>
                    </label>
                </div>

                <!-- Is Active -->
                <div class="form-control">
                    <label class="label cursor-pointer justify-start gap-4">
                        <input
                            type="checkbox"
                            name="is_active"
                            class="checkbox checkbox-primary"
                            {{ old('is_active', true) ? 'checked' : '' }}
                        />
                        <div>
                            <span class="label-text font-medium">Active</span>
                            <p class="text-sm text-base-content/60">Enable this domain immediately</p>
                        </div>
                    </label>
                </div>

                <!-- Actions -->
                <div class="card-actions justify-end mt-6 pt-6 border-t border-base-300">
                    <a href="{{ route('domains.index') }}" class="btn btn-ghost">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Create Domain
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
