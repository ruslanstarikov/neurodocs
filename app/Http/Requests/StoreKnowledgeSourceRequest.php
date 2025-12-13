<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreKnowledgeSourceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:knowledge_sources,slug',
            'type' => 'required|in:codebase,database',
            'description' => 'nullable|string',
        ];

        // Type-specific validation
        if ($this->input('type') === 'codebase') {
            $rules['git_url'] = 'required|string';
            $rules['branch'] = 'nullable|string';
            $rules['ssh_public_key'] = 'required|string';
            $rules['ssh_private_key'] = 'required|string';
        }

        if ($this->input('type') === 'database') {
            $rules['host'] = 'required|string';
            $rules['port'] = 'required|integer';
            $rules['database'] = 'required|string';
            $rules['username'] = 'required|string';
            $rules['password'] = 'required|string';
            $rules['ssl'] = 'boolean';
        }

        return $rules;
    }

    public function configPayload(): array
    {
        if ($this->input('type') === 'codebase') {
            return [
                'git_url' => $this->input('git_url'),
                'branch' => $this->input('branch', 'main'),
                'ssh_public_key' => $this->input('ssh_public_key'),
                'ssh_private_key' => $this->input('ssh_private_key'),
            ];
        }

        if ($this->input('type') === 'database') {
            return [
                'driver' => 'mysql',
                'host' => $this->input('host'),
                'port' => (int) $this->input('port', 3306),
                'database' => $this->input('database'),
                'username' => $this->input('username'),
                'password' => $this->input('password'),
                'ssl' => (bool) $this->input('ssl', false),
            ];
        }

        return [];
    }

    public function baseAttributes(): array
    {
        return [
            'name' => $this->input('name'),
            'slug' => $this->input('slug'),
            'type' => $this->input('type'),
            'description' => $this->input('description'),
            'is_active' => $this->has('is_active'),
            'config' => $this->configPayload(),
        ];
    }
}
