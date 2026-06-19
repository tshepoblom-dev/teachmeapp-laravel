<?php

namespace App\Agora;

class RtcTokenBuilder
{
    const RolePublisher  = 1;
    const RoleSubscriber = 2;
    const RoleAdmin      = 101;

    /**
     * Build an RTC token using a string user account (recommended).
     */
    public static function buildTokenWithUserAccount(
        string $appId,
        string $appCertificate,
        string $channelName,
        string $userAccount,
        int    $role,
        int    $privilegeExpiredTs,
    ): string {
        $token = new AccessToken($appId, $appCertificate, $channelName, $userAccount);

        $token->addPrivilege(AccessToken::PRIVILEGE_JOIN_CHANNEL, $privilegeExpiredTs);

        if (in_array($role, [self::RolePublisher, self::RoleAdmin], true)) {
            $token->addPrivilege(AccessToken::PRIVILEGE_PUBLISH_AUDIO_STREAM, $privilegeExpiredTs);
            $token->addPrivilege(AccessToken::PRIVILEGE_PUBLISH_VIDEO_STREAM, $privilegeExpiredTs);
            $token->addPrivilege(AccessToken::PRIVILEGE_PUBLISH_DATA_STREAM,  $privilegeExpiredTs);
        }

        return $token->build();
    }

    /**
     * Build an RTC token using a numeric UID.
     * UID 0 is treated as wildcard and converted to empty string per Agora spec.
     */
    public static function buildTokenWithUid(
        string $appId,
        string $appCertificate,
        string $channelName,
        int    $uid,
        int    $role,
        int    $privilegeExpiredTs,
    ): string {
        return static::buildTokenWithUserAccount(
            $appId,
            $appCertificate,
            $channelName,
            $uid === 0 ? '' : (string) $uid,
            $role,
            $privilegeExpiredTs,
        );
    }
}