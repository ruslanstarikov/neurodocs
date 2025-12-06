<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DomainController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $domains = Domain::latest()->paginate(10);
        return view('domains.index', compact('domains'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('domains.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $slug = Str::slug($validated['name']);

        // Check if slug already exists
        if (Domain::where('slug', $slug)->exists()) {
            return back()
                ->withInput()
                ->withErrors(['name' => 'A domain with this name already exists.']);
        }

        $validated['slug'] = $slug;
        $validated['is_active'] = $request->has('is_active');

        Domain::create($validated);

        return redirect()->route('domains.index')
            ->with('success', 'Domain created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Domain $domain)
    {
        return view('domains.show', compact('domain'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Domain $domain)
    {
        return view('domains.edit', compact('domain'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Domain $domain)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $slug = Str::slug($validated['name']);

        // Check if slug already exists (except for current domain)
        if (Domain::where('slug', $slug)->where('id', '!=', $domain->id)->exists()) {
            return back()
                ->withInput()
                ->withErrors(['name' => 'A domain with this name already exists.']);
        }

        $validated['slug'] = $slug;
        $validated['is_active'] = $request->has('is_active');

        $domain->update($validated);

        return redirect()->route('domains.index')
            ->with('success', 'Domain updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Domain $domain)
    {
        $domain->delete();

        if (request()->header('HX-Request')) {
            return response('', 200);
        }

        return redirect()->route('domains.index')
            ->with('success', 'Domain deleted successfully.');
    }

    /**
     * Manage the specified domain's knowledge sources.
     */
    public function manage(Domain $domain)
    {
        return view('domains.manage', compact('domain'));
    }
}
