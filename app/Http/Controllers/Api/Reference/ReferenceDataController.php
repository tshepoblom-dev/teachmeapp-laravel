<?php

namespace App\Http\Controllers\Api\Reference;

use App\Http\Controllers\Controller;
use App\Http\Resources\InstitutionResource;
use App\Http\Resources\SubjectResource;
use App\Models\Institution;
use App\Models\Subject;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReferenceDataController extends Controller
{
    use ApiResponse;

    // ── GET /api/institutions ─────────────────────────────────────────────────

    public function institutions(Request $request): JsonResponse
    {
        $institutions = Institution::active()
            ->orderBy('sort_order')->orderBy('name')
            ->get(['id', 'name', 'abbreviation', 'type']);

        return $this->success(InstitutionResource::collection($institutions));
    }

    // ── GET /api/subjects ──────────────────────────────────────────────────────

    public function subjects(Request $request): JsonResponse
    {
        $request->validate([
            'institution_id' => ['nullable', 'integer', 'exists:institutions,id'],
        ]);

        $query = Subject::where('is_active', true)
            ->orderBy('sort_order')->orderBy('name');

        if ($institutionId = $request->query('institution_id')) {
            $query->where(fn ($q) => $q
                ->where('institution_id', $institutionId)
                ->orWhereNull('institution_id'));
        }

        $subjects = $query->get(['id', 'name', 'code', 'faculty', 'institution_id']);

        return $this->success(SubjectResource::collection($subjects));
    }
}
