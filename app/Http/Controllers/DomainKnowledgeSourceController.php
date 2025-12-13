<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKnowledgeSourceRequest;
use App\Http\Requests\UpdateKnowledgeSourceRequest;
use App\Models\Domain;
use App\Models\KnowledgeSource;
use App\Services\KnowledgeSourceService;

class DomainKnowledgeSourceController extends Controller
{
    protected KnowledgeSourceService $service;

    public function __construct(KnowledgeSourceService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of knowledge sources for the domain.
     */
    public function index(Domain $domain)
    {
        $knowledgeSources = $domain->knowledgeSources()->latest()->paginate(10);

        return view('domains.knowledge-sources.index', compact('domain', 'knowledgeSources'));
    }

    /**
     * Show the form for creating a new knowledge source.
     */
    public function create(Domain $domain)
    {
        return view('domains.knowledge-sources.create', compact('domain'));
    }

    /**
     * Store a newly created knowledge source.
     */
    public function store(StoreKnowledgeSourceRequest $request, Domain $domain)
    {
        $this->service->createForDomain($domain, $request->baseAttributes());

        return redirect()
            ->route('domains.knowledge-sources.index', $domain)
            ->with('success', 'Knowledge source created successfully.');
    }

    /**
     * Show the form for editing the knowledge source.
     */
    public function edit(Domain $domain, KnowledgeSource $knowledgeSource)
    {
        // Ensure the knowledge source belongs to this domain
        if (!$this->service->belongsToDomain($domain, $knowledgeSource)) {
            abort(404, 'Knowledge source not found for this domain.');
        }

        return view('domains.knowledge-sources.edit', compact('domain', 'knowledgeSource'));
    }

    /**
     * Update the specified knowledge source.
     */
    public function update(UpdateKnowledgeSourceRequest $request, Domain $domain, KnowledgeSource $knowledgeSource)
    {
        $this->service->updateForDomain($domain, $knowledgeSource, $request->baseAttributes());

        return redirect()
            ->route('domains.knowledge-sources.index', $domain)
            ->with('success', 'Knowledge source updated successfully.');
    }

    /**
     * Remove the specified knowledge source.
     */
    public function destroy(Domain $domain, KnowledgeSource $knowledgeSource)
    {
        $this->service->deleteFromDomain($domain, $knowledgeSource);

        if (request()->header('HX-Request')) {
            return response('', 200);
        }

        return redirect()
            ->route('domains.knowledge-sources.index', $domain)
            ->with('success', 'Knowledge source deleted successfully.');
    }
}
