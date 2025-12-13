<?php

namespace App\Services;

use App\Models\Domain;
use App\Models\KnowledgeSource;

class KnowledgeSourceService
{
    /**
     * Create a new knowledge source and attach it to the domain.
     */
    public function createForDomain(Domain $domain, array $data): KnowledgeSource
    {
        $knowledgeSource = KnowledgeSource::create($data);

        // Attach to the domain
        $domain->knowledgeSources()->attach($knowledgeSource->id);

        return $knowledgeSource;
    }

    /**
     * Update an existing knowledge source.
     */
    public function updateForDomain(Domain $domain, KnowledgeSource $knowledgeSource, array $data): KnowledgeSource
    {
        // Ensure the knowledge source belongs to this domain
        if (!$domain->knowledgeSources()->where('knowledge_sources.id', $knowledgeSource->id)->exists()) {
            abort(404, 'Knowledge source not found for this domain.');
        }

        $knowledgeSource->update($data);

        return $knowledgeSource->fresh();
    }

    /**
     * Delete a knowledge source from the domain.
     */
    public function deleteFromDomain(Domain $domain, KnowledgeSource $knowledgeSource): void
    {
        // Ensure the knowledge source belongs to this domain
        if (!$domain->knowledgeSources()->where('knowledge_sources.id', $knowledgeSource->id)->exists()) {
            abort(404, 'Knowledge source not found for this domain.');
        }

        // Detach from the domain
        $domain->knowledgeSources()->detach($knowledgeSource->id);

        // For v1, also delete the knowledge source record itself
        // In the future, you might want to keep it if other domains use it
        $knowledgeSource->delete();
    }

    /**
     * Check if a knowledge source belongs to a domain.
     */
    public function belongsToDomain(Domain $domain, KnowledgeSource $knowledgeSource): bool
    {
        return $domain->knowledgeSources()->where('knowledge_sources.id', $knowledgeSource->id)->exists();
    }
}
