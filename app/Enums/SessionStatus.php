<?php

namespace App\Enums;

enum SessionStatus: string
{
    /** Session created, no one has joined yet */
    case Waiting    = 'waiting';

    /** At least one party has joined the Agora channel */
    case Active     = 'active';

    /** Tutor has explicitly clicked "Start" — billing clock running */
    case InProgress = 'in_progress';

    /** Session ended normally — escrow released */
    case Ended      = 'ended';

    /** Nobody joined — flagged for admin review, escrow held */
    case Abandoned  = 'abandoned';

    /** Disputed by a participant — admin must arbitrate */
    case Disputed   = 'disputed';

    /** Returns true if the session can still be joined */
    public function isJoinable(): bool
    {
        return in_array($this, [self::Waiting, self::Active, self::InProgress], true);
    }

    /** Returns true if the session is live (video channel open) */
    public function isLive(): bool
    {
        return in_array($this, [self::Active, self::InProgress], true);
    }

    /** Returns true if the session can be ended by a participant */
    public function isEndable(): bool
    {
        return in_array($this, [self::Active, self::InProgress], true);
    }

    public function label(): string
    {
        return match ($this) {
            self::Waiting    => 'Waiting',
            self::Active     => 'Joined',
            self::InProgress => 'In Progress',
            self::Ended      => 'Ended',
            self::Abandoned  => 'Abandoned',
            self::Disputed   => 'Disputed',
        };
    }
}
