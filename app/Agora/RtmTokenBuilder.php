<?php

namespace App\Agora;

class RtmTokenBuilder
{
    const RoleRtmUser = 1;

    /**
     * Build an RTM token for a given user ID.
     * RTM tokens are user-scoped (not channel-scoped), so channelName is always "".
     */
    public static function buildToken(
        string $appId,
        string $appCertificate,
        string $userId,
        int    $role,
        int    $privilegeExpiredTs,
    ): string {
        $token = new AccessToken($appId, $appCertificate, '', $userId);
        $token->addPrivilege(AccessToken::PRIVILEGE_RTM_LOGIN, $privilegeExpiredTs);

        return $token->build();
    }
}