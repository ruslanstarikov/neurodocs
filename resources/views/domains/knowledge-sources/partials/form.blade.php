@php
    $source = $knowledgeSource ?? null;
    $config = $source?->config ?? [];
    $currentType = old('type', $source?->type ?? 'codebase');
@endphp

<!-- Common Fields -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Name -->
    <div class="form-control w-full">
        <label class="label">
            <span class="label-text font-medium">Name <span class="text-error">*</span></span>
        </label>
        <input
            type="text"
            name="name"
            value="{{ old('name', $source?->name) }}"
            placeholder="Enter source name"
            class="input input-bordered w-full @error('name') input-error @enderror"
            required
            id="source-name"
            oninput="updateSlug()"
        />
        @error('name')
        <label class="label">
            <span class="label-text-alt text-error">{{ $message }}</span>
        </label>
        @enderror
    </div>

    <!-- Slug -->
    <div class="form-control w-full">
        <label class="label">
            <span class="label-text font-medium">Slug <span class="text-error">*</span></span>
        </label>
        <input
            type="text"
            name="slug"
            value="{{ old('slug', $source?->slug) }}"
            placeholder="auto-generated-slug"
            class="input input-bordered w-full @error('slug') input-error @enderror"
            required
            id="source-slug"
        />
        @error('slug')
        <label class="label">
            <span class="label-text-alt text-error">{{ $message }}</span>
        </label>
        @enderror
        <label class="label">
            <span class="label-text-alt">Auto-generated from name (can be customized)</span>
        </label>
    </div>
</div>

<!-- Type Selection -->
<div class="form-control w-full">
    <label class="label">
        <span class="label-text font-medium">Type <span class="text-error">*</span></span>
    </label>
    <select
        name="type"
        id="source-type"
        class="select select-bordered w-full @error('type') select-error @enderror"
        required
        onchange="toggleTypeFields()"
    >
        <option value="codebase" {{ $currentType === 'codebase' ? 'selected' : '' }}>Codebase (Git Repository)</option>
        <option value="database" {{ $currentType === 'database' ? 'selected' : '' }}>Database (MySQL)</option>
    </select>
    @error('type')
    <label class="label">
        <span class="label-text-alt text-error">{{ $message }}</span>
    </label>
    @enderror
</div>

<!-- Description -->
<div class="form-control w-full">
    <label class="label">
        <span class="label-text font-medium">Description</span>
    </label>
    <textarea
        name="description"
        rows="3"
        placeholder="Enter source description"
        class="textarea textarea-bordered w-full @error('description') textarea-error @enderror"
    >{{ old('description', $source?->description) }}</textarea>
    @error('description')
    <label class="label">
        <span class="label-text-alt text-error">{{ $message }}</span>
    </label>
    @enderror
</div>

<!-- Is Active -->
<div class="form-control">
    <label class="label cursor-pointer justify-start gap-4">
        <input
            type="checkbox"
            name="is_active"
            class="checkbox checkbox-primary"
            {{ old('is_active', $source?->is_active ?? true) ? 'checked' : '' }}
        />
        <div>
            <span class="label-text font-medium">Active</span>
            <p class="text-sm text-base-content/60">Enable this knowledge source</p>
        </div>
    </label>
</div>

<div class="divider"></div>

<!-- Codebase Configuration Fields -->
<div id="codebase-fields" class="space-y-4" style="display: none;">
    <h3 class="text-lg font-semibold flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
        </svg>
        Codebase Configuration
    </h3>

    <!-- Git URL -->
    <div class="form-control w-full">
        <label class="label">
            <span class="label-text font-medium">Git URL (SSH) <span class="text-error">*</span></span>
        </label>
        <input
            type="text"
            name="git_url"
            value="{{ old('git_url', $config['git_url'] ?? '') }}"
            placeholder="git@github.com:org/repo.git"
            class="input input-bordered w-full font-mono text-sm @error('git_url') input-error @enderror"
        />
        @error('git_url')
        <label class="label">
            <span class="label-text-alt text-error">{{ $message }}</span>
        </label>
        @enderror
        <label class="label">
            <span class="label-text-alt">SSH URL (e.g., GitHub, GitLab, Bitbucket)</span>
        </label>
    </div>

    <!-- Branch -->
    <div class="form-control w-full">
        <label class="label">
            <span class="label-text font-medium">Branch</span>
        </label>
        <input
            type="text"
            name="branch"
            value="{{ old('branch', $config['branch'] ?? 'main') }}"
            placeholder="main"
            class="input input-bordered w-full @error('branch') input-error @enderror"
        />
        @error('branch')
        <label class="label">
            <span class="label-text-alt text-error">{{ $message }}</span>
        </label>
        @enderror
        <label class="label">
            <span class="label-text-alt">Default: main</span>
        </label>
    </div>

    <!-- SSH Public Key -->
    <div class="form-control w-full">
        <label class="label">
            <span class="label-text font-medium">SSH Public Key <span class="text-error">*</span></span>
        </label>
        <textarea
            name="ssh_public_key"
            rows="4"
            placeholder="-----BEGIN PUBLIC KEY-----&#10;...&#10;-----END PUBLIC KEY-----"
            class="textarea textarea-bordered w-full font-mono text-xs @error('ssh_public_key') textarea-error @enderror"
        >{{ old('ssh_public_key', $config['ssh_public_key'] ?? '') }}</textarea>
        @error('ssh_public_key')
        <label class="label">
            <span class="label-text-alt text-error">{{ $message }}</span>
        </label>
        @enderror
    </div>

    <!-- SSH Private Key -->
    <div class="form-control w-full">
        <label class="label">
            <span class="label-text font-medium">
                SSH Private Key
                @if($isEdit)
                <span class="text-sm font-normal text-base-content/60">(leave blank to keep existing)</span>
                @else
                <span class="text-error">*</span>
                @endif
            </span>
        </label>
        <textarea
            name="ssh_private_key"
            rows="6"
            placeholder="-----BEGIN OPENSSH PRIVATE KEY-----&#10;...&#10;-----END OPENSSH PRIVATE KEY-----"
            class="textarea textarea-bordered w-full font-mono text-xs @error('ssh_private_key') textarea-error @enderror"
        >{{ old('ssh_private_key') }}</textarea>
        @error('ssh_private_key')
        <label class="label">
            <span class="label-text-alt text-error">{{ $message }}</span>
        </label>
        @enderror
        @if($isEdit && !empty($config['ssh_private_key']))
        <label class="label">
            <span class="label-text-alt text-success">Private key is currently set</span>
        </label>
        @endif
    </div>
</div>

<!-- Database Configuration Fields -->
<div id="database-fields" class="space-y-4" style="display: none;">
    <h3 class="text-lg font-semibold flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
        </svg>
        Database Configuration (MySQL)
    </h3>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Host -->
        <div class="form-control w-full">
            <label class="label">
                <span class="label-text font-medium">Host <span class="text-error">*</span></span>
            </label>
            <input
                type="text"
                name="host"
                value="{{ old('host', $config['host'] ?? '') }}"
                placeholder="db.example.com"
                class="input input-bordered w-full @error('host') input-error @enderror"
            />
            @error('host')
            <label class="label">
                <span class="label-text-alt text-error">{{ $message }}</span>
            </label>
            @enderror
        </div>

        <!-- Port -->
        <div class="form-control w-full">
            <label class="label">
                <span class="label-text font-medium">Port <span class="text-error">*</span></span>
            </label>
            <input
                type="number"
                name="port"
                value="{{ old('port', $config['port'] ?? 3306) }}"
                placeholder="3306"
                class="input input-bordered w-full @error('port') input-error @enderror"
            />
            @error('port')
            <label class="label">
                <span class="label-text-alt text-error">{{ $message }}</span>
            </label>
            @enderror
        </div>
    </div>

    <!-- Database Name -->
    <div class="form-control w-full">
        <label class="label">
            <span class="label-text font-medium">Database Name <span class="text-error">*</span></span>
        </label>
        <input
            type="text"
            name="database"
            value="{{ old('database', $config['database'] ?? '') }}"
            placeholder="app_production"
            class="input input-bordered w-full @error('database') input-error @enderror"
        />
        @error('database')
        <label class="label">
            <span class="label-text-alt text-error">{{ $message }}</span>
        </label>
        @enderror
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Username -->
        <div class="form-control w-full">
            <label class="label">
                <span class="label-text font-medium">Username <span class="text-error">*</span></span>
            </label>
            <input
                type="text"
                name="username"
                value="{{ old('username', $config['username'] ?? '') }}"
                placeholder="readonly_user"
                class="input input-bordered w-full @error('username') input-error @enderror"
            />
            @error('username')
            <label class="label">
                <span class="label-text-alt text-error">{{ $message }}</span>
            </label>
            @enderror
        </div>

        <!-- Password -->
        <div class="form-control w-full">
            <label class="label">
                <span class="label-text font-medium">
                    Password
                    @if($isEdit)
                    <span class="text-sm font-normal text-base-content/60">(leave blank to keep existing)</span>
                    @else
                    <span class="text-error">*</span>
                    @endif
                </span>
            </label>
            <input
                type="password"
                name="password"
                value="{{ old('password') }}"
                placeholder="{{ $isEdit ? '••••••••' : 'Enter password' }}"
                class="input input-bordered w-full @error('password') input-error @enderror"
            />
            @error('password')
            <label class="label">
                <span class="label-text-alt text-error">{{ $message }}</span>
            </label>
            @enderror
            @if($isEdit && !empty($config['password']))
            <label class="label">
                <span class="label-text-alt text-success">Password is currently set</span>
            </label>
            @endif
        </div>
    </div>

    <!-- SSL -->
    <div class="form-control">
        <label class="label cursor-pointer justify-start gap-4">
            <input
                type="checkbox"
                name="ssl"
                class="checkbox checkbox-primary"
                {{ old('ssl', $config['ssl'] ?? false) ? 'checked' : '' }}
            />
            <div>
                <span class="label-text font-medium">Use SSL/TLS</span>
                <p class="text-sm text-base-content/60">Enable secure connection to database</p>
            </div>
        </label>
    </div>
</div>

@push('scripts')
<script>
    // Slug generation
    function updateSlug() {
        const nameInput = document.getElementById('source-name');
        const slugInput = document.getElementById('source-slug');

        if (!slugInput.dataset.manual) {
            const slug = nameInput.value
                .toLowerCase()
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/^-+|-+$/g, '');
            slugInput.value = slug;
        }
    }

    // Mark slug as manually edited if user types in it
    document.getElementById('source-slug').addEventListener('input', function() {
        this.dataset.manual = 'true';
    });

    // Toggle type-specific fields
    function toggleTypeFields() {
        const type = document.getElementById('source-type').value;
        const codebaseFields = document.getElementById('codebase-fields');
        const databaseFields = document.getElementById('database-fields');

        if (type === 'codebase') {
            codebaseFields.style.display = 'block';
            databaseFields.style.display = 'none';
        } else if (type === 'database') {
            codebaseFields.style.display = 'none';
            databaseFields.style.display = 'block';
        }
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        toggleTypeFields();
    });
</script>
@endpush
