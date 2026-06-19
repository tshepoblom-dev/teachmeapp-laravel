<?php

namespace App\Services;

use App\Models\AgoraChannel;
use App\Agora\RtcTokenBuilder;
use App\Agora\RtmTokenBuilder;
use App\Models\Session;
use BoogieFromZk\AgoraToken\RtcTokenBuilder2;
use BoogieFromZk\AgoraToken\RtmTokenBuilder2;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AgoraService
{
    // Agora privilege expiry — tokens are short-lived and regenerated on every join
    private const TOKEN_EXPIRY_SECONDS = 3600; // 1 hour

    // Agora role constants (defined by Agora RTC spec)
    private const ROLE_PUBLISHER   = 1;
    private const ROLE_SUBSCRIBER  = 2;

    // Privilege kinds used in RTC token
    private const PRIVILEGE_JOIN_CHANNEL      = 1;
    private const PRIVILEGE_PUBLISH_AUDIO     = 2;
    private const PRIVILEGE_PUBLISH_VIDEO     = 3;
    private const PRIVILEGE_PUBLISH_DATASTREAM = 4;

    private string $appId;
    private string $appCertificate;

    public function __construct()
    {
        $this->appId          = config('agora.app_id', '');
        $this->appCertificate = config('agora.app_certificate', '');

        if (empty($this->appId) || empty($this->appCertificate)) {
            Log::warning('AgoraService: credentials not configured — token generation will be skipped');
        }
    }

    // =========================================================================
    // Generate a unique channel name for a session
    // Format: sess_{bookingId}_{randomHex8}
    // =========================================================================

    public function generateChannelName(int $bookingId): string
    {
        return 'sess_' . $bookingId . '_' . Str::random(8);
    }

    // =========================================================================
    // Generate an RTC token for a given uid on a channel
    // role: 'publisher' (tutor/student with camera) | 'subscriber' (observer)
    // =========================================================================

    public function generateRtcToken(
        string $channelName,
        int    $uid,
        string $role = 'publisher',
    ): string {
        if (empty($this->appId) || empty($this->appCertificate)) {
            Log::warning('Agora credentials not configured — returning empty token');
            return '';
        }
         $agoraRole = $role === 'publisher'
            ? RtcTokenBuilder2::ROLE_PUBLISHER
            : RtcTokenBuilder2::ROLE_SUBSCRIBER;

        $token = RtcTokenBuilder2::buildTokenWithUid(
             $this->appId, $this->appCertificate,  $channelName, $uid, $agoraRole,time() + self::TOKEN_EXPIRY_SECONDS,
        );
        return (string)$token;
    }

     // ── RTM token ─────────────────────────────────────────────────────────────

    public function generateRtmToken(int $userId): string
    {
        if (! $this->isConfigured()) {
            Log::warning('Agora credentials not configured — returning empty RTM token');
            return '';
        }

        $token = RtmTokenBuilder2::buildToken(
            $this->appId,
            $this->appCertificate,
            (string) $this->uidForUser($userId),
            time() + self::TOKEN_EXPIRY_SECONDS,
        );
        return (string)$token;
    }

    // ── Refresh (called on every join) ────────────────────────────────────────

    public function refreshTokens(Session $session): array
    {
        $studentToken = $this->generateRtcToken(
            channelName: $session->agora_channel_name,
            uid:         $session->agora_uid_student,
            role:        'publisher',
        );

        $tutorToken = $this->generateRtcToken(
            channelName: $session->agora_channel_name,
            uid:         $session->agora_uid_tutor,
            role:        'publisher',
        );

        $session->update([
            'agora_token_student' => $studentToken,
            'agora_token_tutor'   => $tutorToken,
        ]);

        return [
            'student' => $studentToken,
            'tutor'   => $tutorToken,
        ];
    }

    // ── Helpers ───────────────────────────────────────────────────────────────

    private function isConfigured(): bool
    {
        return $this->appId !== '' && $this->appCertificate !== '';
    }

    // =========================================================================
    // Assign deterministic UIDs from user IDs
    // Agora UIDs must be uint32 — we use the user ID directly (safe for platforms
    // with fewer than ~4 billion users)
    // =========================================================================

    public function uidForUser(int $userId): int
    {
        // Agora UIDs are unsigned 32-bit. Laravel bigint user IDs can exceed this
        // on very large platforms. We use modulo to keep within safe range while
        // maintaining per-session uniqueness (channel name scopes the session).
        return $userId % 4294967295;
    }

    // =========================================================================
    // Token expiry helper — returns seconds remaining on stored token
    // =========================================================================

    public function tokenExpiresInSeconds(): int
    {
        return self::TOKEN_EXPIRY_SECONDS;
    }

    // =========================================================================
    // SELF-CONTAINED AGORA RTC TOKEN BUILDER
    // Based on the official Agora AccessToken spec (v006)
    // No external package required.
    // =========================================================================

    private function buildRtcToken(
        string $appId,
        string $appCertificate,
        string $channelName,
        int    $uid,
        int    $role,
        int    $expireTimestamp,
    ): string {
        $currentTimestamp = time();
        $salt             = random_int(1, 99999999);

        // Pack message content
        $message = pack('N', $salt)
            . pack('N', $currentTimestamp)
            . pack('N', $expireTimestamp)
            . $this->packPrivileges($role, $expireTimestamp);

        // Build signing content
        $signing = $appId . $channelName . (string) $uid . $message;

        // HMAC-SHA256 signature
        $signature = hash_hmac('sha256', $signing, $appCertificate, true);

        // Pack content into token
        $content = $message . pack('n', strlen($signature)) . $signature;

        // Build final token string
        $token = '006'
            . $appId
            . pack('n', strlen($content))
            . $content;

        return base64_encode($token);
    }

    private function packPrivileges(int $role, int $expireTimestamp): string
    {
        // Privileges map depends on role
        $privileges = [
            self::PRIVILEGE_JOIN_CHANNEL => $expireTimestamp,
        ];

        if ($role === self::ROLE_PUBLISHER) {
            $privileges[self::PRIVILEGE_PUBLISH_AUDIO]      = $expireTimestamp;
            $privileges[self::PRIVILEGE_PUBLISH_VIDEO]      = $expireTimestamp;
            $privileges[self::PRIVILEGE_PUBLISH_DATASTREAM] = $expireTimestamp;
        }

        $packed = pack('n', count($privileges));
        foreach ($privileges as $key => $value) {
            $packed .= pack('n', $key) . pack('N', $value);
        }

        return $packed;
    }
}