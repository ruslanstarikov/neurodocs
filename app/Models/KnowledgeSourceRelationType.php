<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KnowledgeSourceRelationType extends Model
{
    protected $table = 'knowledge_source_relation_types';

    protected $fillable = [
        'name',
        'description',
    ];

    public function relations(): HasMany
    {
        return $this->hasMany(KnowledgeSourceRelation::class, 'relation_type_id');
    }
}
