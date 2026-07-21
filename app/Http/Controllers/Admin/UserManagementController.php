<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UserDeletionService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Inertia\Inertia;
use Inertia\Response;

class UserManagementController extends Controller
{
    public function __construct(
        private readonly UserDeletionService $userDeletionService,
    ) {}

    public function index(Request $request): Response
    {
        $users = User::with(['profile'])
            ->when($request->search, fn ($q) =>
                $q->where(fn ($q2) =>
                    $q2->where('name', 'like', "%{$request->search}%")
                       ->orWhere('email', 'like', "%{$request->search}%")
                )
            )
            ->when($request->role, fn ($q) => $q->where('role', $request->role))
            ->when($request->status, fn ($q) => $q->where('account_status', $request->status))
            ->latest()
            ->paginate(20)
            ->withQueryString()
            ->through(fn ($u) => [
                'id'             => $u->id,
                'name'           => $u->name,
                'email'          => $u->email,
                'role'           => $u->role->value,
                'account_status' => $u->account_status->value,
                'kyc_status'     => $u->profile?->kyc_status,
                'created_at'     => $u->created_at->toDateString(),
                'last_login_at'  => $u->last_login_at?->diffForHumans(),
            ]);

        return Inertia::render('Admin/Users/Index', [
            'users'   => $users,
            'filters' => $request->only(['search', 'role', 'status']),
        ]);
    }

    public function show(User $user): Response
    {
        $user->load([
            'profile.tutorTier',
            'wallet',
            'kycApplications.documents',
        ]);

        $bookingStats = [
            'as_student' => \App\Models\Booking::where('student_id', $user->id)->count(),
            'as_tutor'   => \App\Models\Booking::where('tutor_id', $user->id)->count(),
            'completed'  => \App\Models\Booking::where(
                fn ($q) => $q->where('student_id', $user->id)->orWhere('tutor_id', $user->id)
            )->where('status', 'completed')->count(),
        ];

        return Inertia::render('Admin/Users/Show', [
            'user'         => $user,
            'bookingStats' => $bookingStats,
        ]);
    }

    public function suspend(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'reason'          => ['required', 'string', 'max:500'],
            'suspended_until' => ['nullable', 'date', 'after:now'],
        ]);

        $user->update([
            'account_status'    => 'suspended',
            'suspension_reason' => $request->reason,
            'suspended_until'   => $request->suspended_until
                ? Carbon::parse($request->suspended_until)
                : null,
        ]);

        Log::info('UserManagementController: user suspended', [
            'admin_id'        => $request->user()->id,
            'target_user_id'  => $user->id,
            'reason'          => $request->reason,
            'suspended_until' => $request->suspended_until,
        ]);

        return back()->with('success', "{$user->name} has been suspended.");
    }

    public function ban(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'reason' => ['required', 'string', 'max:500'],
        ]);

        $user->update([
            'account_status'    => 'banned',
            'suspension_reason' => $request->reason,
        ]);

        Log::warning('UserManagementController: user banned', [
            'admin_id'       => $request->user()->id,
            'target_user_id' => $user->id,
            'email'          => $user->email,
            'reason'         => $request->reason,
        ]);

        return back()->with('success', "{$user->name} has been banned.");
    }

    public function activate(User $user): RedirectResponse
    {
        $user->update([
            'account_status'    => 'active',
            'suspended_until'   => null,
            'suspension_reason' => null,
        ]);

        Log::info('UserManagementController: user activated', [
            'admin_id'       => request()->user()->id,
            'target_user_id' => $user->id,
        ]);

        return back()->with('success', "{$user->name}'s account has been activated.");
    }

    public function updatePassword(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'confirmed', PasswordRule::min(8)->letters()->mixedCase()->numbers()],
        ]);

        $user->update(['password' => Hash::make($request->password)]);
        $user->tokens()->delete();

        Log::info('UserManagementController: admin reset user password', [
            'admin_id'       => $request->user()->id,
            'target_user_id' => $user->id,
        ]);

        return back()->with('success', "Password updated for {$user->name}. All active sessions have been revoked.");
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        $name = $user->name;

        try {
            $this->userDeletionService->delete($user, $request->user());
        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }

        Log::warning('UserManagementController: user deleted', [
            'admin_id'       => $request->user()->id,
            'target_user_id' => $user->id,
            'email'          => $user->email,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', "{$name}'s account has been deleted.");
    }

    public function sendPasswordResetLink(User $user): RedirectResponse
    {
        Password::sendResetLink(['email' => $user->email]);

        Log::info('UserManagementController: admin triggered password reset link', [
            'admin_id'       => request()->user()->id,
            'target_user_id' => $user->id,
            'email'          => $user->email,
        ]);

        return back()->with('success', "Password reset link sent to {$user->email}.");
    }
}
