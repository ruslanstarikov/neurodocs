<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Domain extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function knowledgeSources(): BelongsToMany
    {
        return $this->belongsToMany(KnowledgeSource::class, 'domain_knowledge_source');
    }
}
