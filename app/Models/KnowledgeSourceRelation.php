<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KnowledgeSourceRelation extends Model
{
    protected $table = 'knowledge_source_relations';

    protected $fillable = [
        'from_knowledge_source_id',
        'to_knowledge_source_id',
        'relation_type_id',
    ];

    public function fromSource(): BelongsTo
    {
        return $this->belongsTo(KnowledgeSource::class, 'from_knowledge_source_id');
    }

    public function toSource(): BelongsTo
    {
        return $this->belongsTo(KnowledgeSource::class, 'to_knowledge_source_id');
    }

    public function relationType(): BelongsTo
    {
        return $this->belongsTo(KnowledgeSourceRelationType::class, 'relation_type_id');
    }
}
