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

    public function outgoingRelations(): HasMany
    {
        return $this->hasMany(KnowledgeSourceRelation::class, 'from_knowledge_source_id');
    }

    public function incomingRelations(): HasMany
    {
        return $this->hasMany(KnowledgeSourceRelation::class, 'to_knowledge_source_id');
    }

    public function relatedTargets(): BelongsToMany
    {
        return $this->belongsToMany(
            KnowledgeSource::class,
            'knowledge_source_relations',
            'from_knowledge_source_id',
            'to_knowledge_source_id'
        );
    }

    public function relatedSources(): BelongsToMany
    {
        return $this->belongsToMany(
            KnowledgeSource::class,
            'knowledge_source_relations',
            'to_knowledge_source_id',
            'from_knowledge_source_id'
        );
    }
}
