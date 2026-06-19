<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Inertia\Inertia;
use Inertia\Response;

class AuthWebController extends Controller
{
    public function __construct(private readonly AuthService $authService) {}

    // ── Login ──────────────────────────────────────────────────────────────

    public function showLogin(): Response|RedirectResponse
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user()->role->value);
        }

        return Inertia::render('Auth/Login');
    }

    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => 'These credentials do not match our records.',
            ]);
        }

        $user = Auth::user();

        if ($user->account_status->value === 'banned') {
            Log::warning('AuthWebController: banned user login attempt', ['user_id' => $user->id, 'ip' => $request->ip()]);
            Auth::logout();
            throw ValidationException::withMessages([
                'email' => 'This account has been permanently banned.',
            ]);
        }

        $request->session()->regenerate();

        Log::info('AuthWebController: web login successful', [
            'user_id' => $user->id,
            'role'    => $user->role->value,
            'ip'      => $request->ip(),
        ]);

        return $this->redirectByRole($user->role->value);
    }

    // ── Register ───────────────────────────────────────────────────────────

    public function showRegister(): Response|RedirectResponse
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user()->role->value);
        }

        return Inertia::render('Auth/Register');
    }

    public function register(RegisterRequest $request): RedirectResponse
    {
        $result = $this->authService->register($request->validated());

        $user = $result['user'];

        // Log the user in via session (web — no Sanctum token needed)
        Auth::login($user);
        $request->session()->regenerate();

        Log::info('AuthWebController: web registration successful', [
            'user_id' => $user->id,
            'role'    => $user->role->value,
        ]);

        // Always redirect to email verification notice first
        return redirect()->route('verification.notice')
            ->with('success', 'Welcome to TeachMe App! Please verify your email address to continue.');
    }

    // ── Email verification ─────────────────────────────────────────────────

    public function verificationNotice(): Response|RedirectResponse
    {
        // Already verified — send straight to their dashboard
        if (Auth::user()->hasVerifiedEmail()) {
            return $this->redirectByRole(Auth::user()->role->value);
        }

        return Inertia::render('Auth/VerifyEmail', [
            'email' => Auth::user()->email,
        ]);
    }

    public function verificationVerify(EmailVerificationRequest $request): RedirectResponse
    {
        if (! $request->user()->hasVerifiedEmail()) {
            $request->fulfill(); // marks verified + fires Verified event
        }

        $user = $request->user();
        $message = $user->role->value === 'tutor'
            ? 'Email verified! Please complete your KYC to start accepting bookings.'
            : 'Email verified! Welcome to TeachMe App.';

        return $this->redirectByRole($user->role->value)
            ->with('success', $message);
    }

    public function verificationResend(Request $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return $this->redirectByRole($request->user()->role->value);
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('success', 'A fresh verification link has been sent to your email.');
    }

    // ── Logout ─────────────────────────────────────────────────────────────

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    // ── Helpers ────────────────────────────────────────────────────────────

    private function redirectByRole(string $role): RedirectResponse
    {
        return match($role) {
            'admin'   => redirect()->intended(route('admin.dashboard')),
            'tutor'   => redirect()->intended(route('tutor.dashboard')),
            'student' => redirect()->intended(route('student.dashboard')),
            default   => redirect()->route('login'),
        };
    }
    // GET /forgot-password
    public function showForgotPassword(): Response|RedirectResponse
    {
        // Redirect already-logged-in users away
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user()->role->value);
        }
        return Inertia::render('Auth/ForgotPassword');
    }

    // POST /forgot-password
    public function sendResetLink(Request $request): RedirectResponse
    {
        $request->validate(['email' => ['required', 'email']]);

        // Always returns success to avoid email enumeration
        Password::sendResetLink($request->only('email'));

        return back()->with('status', 'If that email is registered, a reset link is on its way.');
    }

    // GET /reset-password/{token}
    public function showResetPassword(Request $request, string $token): Response
    {
        return Inertia::render('Auth/ResetPassword', [
            'token' => $token,
            'email' => $request->query('email', ''),
        ]);
    }

    // POST /reset-password
    public function resetPassword(Request $request): RedirectResponse
    {
        $request->validate([
            'token'    => ['required'],
            'email'    => ['required', 'email'],
            'password' => ['required', 'confirmed', PasswordRule::min(8)->letters()->mixedCase()->numbers()],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill(['password' => Hash::make($password), 'remember_token' => Str::random(60)])->save();
                $user->tokens()->delete(); // revoke all Sanctum tokens
                event(new PasswordReset($user));
            }
        );

        if ($status !== Password::PASSWORD_RESET) {
            throw ValidationException::withMessages(['email' => [__($status)]]);
        }

        return redirect()->route('login')->with('status', 'Password reset! You can now sign in.');
    }
}