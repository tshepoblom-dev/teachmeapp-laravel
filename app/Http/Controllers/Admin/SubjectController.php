<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Institution;
use App\Models\Subject;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SubjectController extends Controller
{
    public function index(Request $request): Response
    {
        $query = Subject::with('institution:id,name,abbreviation')
            ->orderBy('sort_order')
            ->orderBy('name');

        if ($request->institution_id) {
            $query->where(fn ($q) =>
                $q->where('institution_id', $request->institution_id)
                  ->orWhereNull('institution_id')
            );
        }

        $subjects = $query->get()->map(fn ($s) => [
            'id'               => $s->id,
            'name'             => $s->name,
            'code'             => $s->code,
            'faculty'          => $s->faculty,
            'institution_id'   => $s->institution_id,
            'institution_name' => $s->institution
                ? "{$s->institution->abbreviation} – {$s->institution->name}"
                : 'Universal (all institutions)',
            'is_active'        => $s->is_active,
            'sort_order'       => $s->sort_order,
        ]);

        $institutions = Institution::active()
            ->orderBy('name')
            ->get(['id', 'name', 'abbreviation']);

        return Inertia::render('Admin/Subjects/Index', [
            'subjects'     => $subjects,
            'institutions' => $institutions,
            'filters'      => $request->only('institution_id'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'           => ['required', 'string', 'max:255'],
            'code'           => ['nullable', 'string', 'max:20'],
            'faculty'        => ['nullable', 'string', 'max:100'],
            'institution_id' => ['nullable', 'exists:institutions,id'],
            'is_active'      => ['boolean'],
            'sort_order'     => ['integer', 'min:0'],
        ]);

        Subject::create($data);

        return back()->with('success', 'Subject created.');
    }

    public function update(Request $request, Subject $subject): RedirectResponse
    {
        $data = $request->validate([
            'name'           => ['required', 'string', 'max:255'],
            'code'           => ['nullable', 'string', 'max:20'],
            'faculty'        => ['nullable', 'string', 'max:100'],
            'institution_id' => ['nullable', 'exists:institutions,id'],
            'is_active'      => ['boolean'],
            'sort_order'     => ['integer', 'min:0'],
        ]);

        $subject->update($data);

        return back()->with('success', 'Subject updated.');
    }

    public function destroy(Subject $subject): RedirectResponse
    {
        $subject->delete();
        return back()->with('success', 'Subject deleted.');
    }
}