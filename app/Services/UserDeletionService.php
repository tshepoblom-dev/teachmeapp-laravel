<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\ChatMessage;
use App\Models\Invoice;
use App\Models\Report;
use App\Models\Review;
use App\Models\SessionPoll;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class UserDeletionService
{
    /**
     * Permanently delete a user account.
     *
     * Most of the user's owned data (profile, wallet, KYC, payout accounts,
     * availability slots, etc.) cascades at the database level. Tables that
     * record activity involving *other* users (bookings, reviews, reports,
     * chat messages, invoices) have no delete cascade on purpose, so those
     * are checked up front and block deletion with a clear reason instead of
     * letting the query fail with a foreign key violation — that activity
     * data (and the financial trail behind it) shouldn't silently disappear.
     */
    public function delete(User $user, User $actingAdmin): void
    {
        if ($user->id === $actingAdmin->id) {
            throw new RuntimeException('You cannot delete your own admin account.');
        }

        $blockers = $this->activityBlockers($user);
        if ($blockers) {
            throw new RuntimeException(
                "{$user->name} can't be deleted because they have existing "
                . implode(', ', $blockers) . '. Ban the account instead if it needs to be disabled.'
            );
        }

        DB::transaction(function () use ($user) {
            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }

            $user->tokens()->delete();
            $user->delete();
        });
    }

    /**
     * @return string[] human-readable reasons deletion is blocked, empty if clear
     */
    private function activityBlockers(User $user): array
    {
        $blockers = [];

        if (Booking::where('student_id', $user->id)->orWhere('tutor_id', $user->id)->exists()) {
            $blockers[] = 'bookings';
        }
        if (Review::where('reviewer_id', $user->id)->orWhere('reviewee_id', $user->id)->exists()) {
            $blockers[] = 'reviews';
        }
        if (Report::where('reporter_id', $user->id)->orWhere('reported_id', $user->id)->exists()) {
            $blockers[] = 'reports';
        }
        if (ChatMessage::where('sender_id', $user->id)->exists()) {
            $blockers[] = 'chat messages';
        }
        if (Invoice::where('student_id', $user->id)->orWhere('tutor_id', $user->id)->exists()) {
            $blockers[] = 'invoices';
        }
        if (SessionPoll::where('created_by', $user->id)->exists()) {
            $blockers[] = 'session polls';
        }

        return $blockers;
    }
}
