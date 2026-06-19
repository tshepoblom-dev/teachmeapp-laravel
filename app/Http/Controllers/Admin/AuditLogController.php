<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AuditLogController extends Controller
{
    public function index(Request $request): Response
    {
        $logs = AuditLog::with(['user:id,name'])
            ->when($request->action, fn ($q) => $q->where('action', 'like', "%{$request->action}%"))
            ->when($request->user_id, fn ($q) => $q->where('user_id', $request->integer('user_id')))
            ->when($request->target_type, fn ($q) => $q->where('target_type', $request->target_type))
            ->when($request->from, fn ($q) =>
                $q->where('created_at', '>=', \Carbon\Carbon::parse($request->from)->startOfDay())
            )
            ->when($request->to, fn ($q) =>
                $q->where('created_at', '<=', \Carbon\Carbon::parse($request->to)->endOfDay())
            )
            ->latest()
            ->paginate(30)
            ->withQueryString()
            ->through(fn ($log) => [
                'id'          => $log->id,
                'action'      => $log->action,
                'target_type' => $log->target_type,
                'target_id'   => $log->target_id,
                'user'        => $log->user?->name ?? 'System',
                'ip_address'  => $log->ip_address,
                'old_values'  => $log->old_values,
                'new_values'  => $log->new_values,
                'created_at'  => $log->created_at->toIso8601String(),
            ]);

        return Inertia::render('Admin/Audit/Index', [
            'logs'       => $logs,
            'filters'    => $request->only(['action', 'user_id', 'target_type', 'from', 'to']),
            'pendingKyc' => \App\Models\KycApplication::where('status', 'pending')->count(),
        ]);
    }
}