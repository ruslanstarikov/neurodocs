<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KnowledgeEntity extends Model
{
    protected $fillable = [
        'knowledge_source_id',
        'entity_type_id',
        'name',
        'external_id',
        'raw_definition',
        'usage_evidence',
        'semantic_label',
        'semantic_summary',
        'semantic_meta',
        'last_schema_at',
        'last_usage_analysis_at',
        'last_semantic_update_at',
    ];

    protected $casts = [
        'raw_definition' => 'array',
        'usage_evidence' => 'array',
        'semantic_meta' => 'array',
        'last_schema_at' => 'datetime',
        'last_usage_analysis_at' => 'datetime',
        'last_semantic_update_at' => 'datetime',
    ];

    public function knowledgeSource(): BelongsTo
    {
        return $this->belongsTo(KnowledgeSource::class);
    }

    public function entityType(): BelongsTo
    {
        return $this->belongsTo(KnowledgeEntityType::class);
    }
}
