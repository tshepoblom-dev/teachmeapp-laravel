<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Institution;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class InstitutionController extends Controller
{
    public function index(): Response
    {
        $institutions = Institution::withCount('subjects')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get()
            ->map(fn ($i) => [
                'id'            => $i->id,
                'name'          => $i->name,
                'abbreviation'  => $i->abbreviation,
                'type'          => $i->type,
                'type_label'    => $i->type_label,
                'city'          => $i->city,
                'province'      => $i->province,
                'website'       => $i->website,
                'is_active'     => $i->is_active,
                'sort_order'    => $i->sort_order,
                'subjects_count'=> $i->subjects_count,
            ]);

        return Inertia::render('Admin/Institutions/Index', [
            'institutions' => $institutions,
            'typeOptions'  => Institution::typeLabels(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'         => ['required', 'string', 'max:255'],
            'abbreviation' => ['nullable', 'string', 'max:20'],
            'type'         => ['required', 'in:university,university_of_technology,private_college,tvet_college,high_school,other'],
            'city'         => ['nullable', 'string', 'max:100'],
            'province'     => ['nullable', 'string', 'max:100'],
            'website'      => ['nullable', 'url', 'max:255'],
            'is_active'    => ['boolean'],
            'sort_order'   => ['integer', 'min:0'],
        ]);

        Institution::create($data);

        return back()->with('success', 'Institution created.');
    }

    public function update(Request $request, Institution $institution): RedirectResponse
    {
        $data = $request->validate([
            'name'         => ['required', 'string', 'max:255'],
            'abbreviation' => ['nullable', 'string', 'max:20'],
            'type'         => ['required', 'in:university,university_of_technology,private_college,tvet_college,high_school,other'],
            'city'         => ['nullable', 'string', 'max:100'],
            'province'     => ['nullable', 'string', 'max:100'],
            'website'      => ['nullable', 'url', 'max:255'],
            'is_active'    => ['boolean'],
            'sort_order'   => ['integer', 'min:0'],
        ]);

        $institution->update($data);

        return back()->with('success', 'Institution updated.');
    }

    public function destroy(Institution $institution): RedirectResponse
    {
        $institution->delete();
        return back()->with('success', 'Institution deleted.');
    }
}