<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KnowledgeEntityType extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    public function entities(): HasMany
    {
        return $this->hasMany(KnowledgeEntity::class, 'entity_type_id');
    }
}
