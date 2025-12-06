<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KnowledgeSource extends Model
{
    protected $fillable = [
        'type',
        'name',
        'slug',
        'description',
        'config',
        'is_active',
    ];

    protected $casts = [
        'config' => 'array',
        'is_active' => 'boolean',
    ];

    public function domains(): BelongsToMany
    {
        return $this->belongsToMany(Domain::class, 'domain_knowledge_source');
    }

    public function entities(): HasMany
    {
        return $this->hasMany(KnowledgeEntity::class);
    }
}
