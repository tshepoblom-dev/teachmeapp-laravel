<?php

namespace App\Services;

use App\Models\AuditLog;
use App\Models\Booking;
use App\Models\ParentUserGuardian;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use RuntimeException;

/**
 * GuardianService
 *
 * Responsibilities:
 *  - Link a guardian account to a student
 *  - Record consent (IP + timestamp)
 *  - Manage permissions: can_book_sessions, can_receive_reports, is_primary_contact
 *  - Unlink guardian
 *  - Guard: check if a guardian may perform a booking on behalf of a student
 */
class GuardianService
{
    // ─── Link ─────────────────────────────────────────────────────────────────

    /**
     * Link a guardian to a student account.
     *
     * Rules:
     *  - Guardian must be a registered user (any role)
     *  - A user cannot be their own guardian
     *  - Link must be unique (enforced by DB unique constraint)
     *
     * @param  array{
     *   guardian_email: string,
     *   relationship: string,
     *   can_book_sessions?: bool,
     *   can_receive_reports?: bool,
     *   is_primary_contact?: bool,
     * } $data
     */
    public function link(User $student, array $data, string $consentIp): ParentUserGuardian
    {
        $guardian = User::where('email', $data['guardian_email'])->first();

        if (! $guardian) {
            throw new RuntimeException('No account found with that email address. The guardian must register first.');
        }

        if ($guardian->id === $student->id) {
            throw new RuntimeException('A user cannot be their own guardian.');
        }

        $alreadyLinked = ParentUserGuardian::where('student_id', $student->id)
            ->where('guardian_id', $guardian->id)
            ->exists();

        if ($alreadyLinked) {
            throw new RuntimeException('This guardian is already linked to your account.');
        }

        return DB::transaction(function () use ($student, $guardian, $data, $consentIp) {
            // Only one primary contact allowed
            if ($data['is_primary_contact'] ?? false) {
                ParentUserGuardian::where('student_id', $student->id)
                    ->update(['is_primary_contact' => false]);
            }

            $link = ParentUserGuardian::create([
                'student_id'          => $student->id,
                'guardian_id'         => $guardian->id,
                'relationship'        => $data['relationship'],
                'can_book_sessions'   => $data['can_book_sessions']   ?? true,
                'can_receive_reports' => $data['can_receive_reports']  ?? true,
                'is_primary_contact'  => $data['is_primary_contact']  ?? false,
                'consent_provided_at' => now(),
                'consent_proof_ip'    => $consentIp,
            ]);

            AuditLog::create([
                'user_id'     => $student->id,
                'action'      => 'guardian_linked',
                'target_type' => 'parent_user_guardian',
                'target_id'   => $link->id,
                'new_values'  => [
                    'guardian_id'  => $guardian->id,
                    'relationship' => $data['relationship'],
                    'consent_ip'   => $consentIp,
                ],
            ]);

            Log::info('GuardianService: guardian linked', [
                'student_id'  => $student->id,
                'guardian_id' => $guardian->id,
                'link_id'     => $link->id,
            ]);

            return $link->load('guardian:id,name,email');
        });
    }

    // ─── Update permissions ───────────────────────────────────────────────────

    /**
     * Update permissions on an existing guardian link.
     *
     * @param  array{
     *   can_book_sessions?: bool,
     *   can_receive_reports?: bool,
     *   is_primary_contact?: bool,
     * } $data
     */
    public function updatePermissions(
        User               $student,
        ParentUserGuardian $link,
        array              $data,
    ): ParentUserGuardian {
        $this->assertOwnership($student, $link);

        return DB::transaction(function () use ($student, $link, $data) {
            if (($data['is_primary_contact'] ?? false) && ! $link->is_primary_contact) {
                ParentUserGuardian::where('student_id', $student->id)
                    ->where('id', '!=', $link->id)
                    ->update(['is_primary_contact' => false]);
            }

            $link->update([
                'can_book_sessions'   => $data['can_book_sessions']   ?? $link->can_book_sessions,
                'can_receive_reports' => $data['can_receive_reports']  ?? $link->can_receive_reports,
                'is_primary_contact'  => $data['is_primary_contact']  ?? $link->is_primary_contact,
            ]);

            AuditLog::create([
                'user_id'     => $student->id,
                'action'      => 'guardian_permissions_updated',
                'target_type' => 'parent_user_guardian',
                'target_id'   => $link->id,
                'new_values'  => $data,
            ]);

            Log::info('GuardianService: guardian permissions updated', [
                'student_id'  => $student->id,
                'link_id'     => $link->id,
                'changes'     => array_keys($data),
            ]);

            return $link->fresh();
        });
    }

    // ─── Unlink ───────────────────────────────────────────────────────────────

    public function unlink(User $student, ParentUserGuardian $link): void
    {
        $this->assertOwnership($student, $link);

        AuditLog::create([
            'user_id'     => $student->id,
            'action'      => 'guardian_unlinked',
            'target_type' => 'parent_user_guardian',
            'target_id'   => $link->id,
            'old_values'  => [
                'guardian_id'  => $link->guardian_id,
                'relationship' => $link->relationship,
            ],
        ]);

        Log::info('GuardianService: guardian unlinked', [
            'student_id'  => $student->id,
            'guardian_id' => $link->guardian_id,
            'link_id'     => $link->id,
        ]);

        $link->delete();
    }

    // ─── List guardians ───────────────────────────────────────────────────────

    public function guardiansFor(User $student): Collection
    {
        return ParentUserGuardian::with('guardian:id,name,email')
            ->where('student_id', $student->id)
            ->get();
    }

    // ─── Permission checks ────────────────────────────────────────────────────

    /**
     * Assert that a guardian is permitted to make bookings for a student.
     *
     * @throws RuntimeException
     */
    public function assertCanBook(User $guardian, User $student): void
    {
        $link = ParentUserGuardian::where('student_id', $student->id)
            ->where('guardian_id', $guardian->id)
            ->first();

        if (! $link) {
            throw new RuntimeException('You are not linked as a guardian for this student.');
        }

        if (! $link->can_book_sessions) {
            throw new RuntimeException('You do not have permission to make bookings for this student.');
        }
    }

    /**
     * Return all students a guardian can book on behalf of.
     */
    public function bookableStudentsFor(User $guardian): Collection
    {
/*        return ParentUserGuardian::with('student:id,name,email')
            ->where('guardian_id', $guardian->id)
            ->where('can_book_sessions', true)
            ->get()
            ->pluck('student');*/
        return User::join('parent_user_guardians', 'users.id', '=', 'parent_user_guardians.student_id')
            ->where('parent_user_guardians.guardian_id', $guardian->id)
            ->where('parent_user_guardians.can_book_sessions', true)
            ->select('users.*')
            ->get();
    }

    // ─── Private ──────────────────────────────────────────────────────────────

    private function assertOwnership(User $student, ParentUserGuardian $link): void
    {
        if ($link->student_id !== $student->id) {
            throw new RuntimeException('This guardian link does not belong to your account.');
        }
    }
}