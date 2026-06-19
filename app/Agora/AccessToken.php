<?php

namespace App\Agora;

class AccessToken
{
    const VERSION        = '006';
    const VERSION_LENGTH = 3;

    // Privilege keys — matches Agora spec exactly
    const PRIVILEGE_JOIN_CHANNEL               = 1;
    const PRIVILEGE_PUBLISH_AUDIO_STREAM       = 2;
    const PRIVILEGE_PUBLISH_VIDEO_STREAM       = 3;
    const PRIVILEGE_PUBLISH_DATA_STREAM        = 4;
    const PRIVILEGE_RTM_LOGIN                  = 1000;

    public string $appId;
    public string $appCertificate;
    public string $channelName;
    public string $uid;           // always a string; 0 becomes ""
    public int    $salt;
    public int    $ts;
    public array  $privileges = [];

    public function __construct(
        string $appId,
        string $appCertificate,
        string $channelName,
        string|int $uid,
    ) {
        $this->appId          = $appId;
        $this->appCertificate = $appCertificate;
        $this->channelName    = $channelName;
        $this->uid            = ($uid === 0 || $uid === '0' || $uid === '') ? '' : (string) $uid;
        $this->salt           = random_int(1, 99_999_999);
        $this->ts             = time() + 100;
    }

    public function addPrivilege(int $privilege, int $expireTimestamp): void
    {
        $this->privileges[$privilege] = $expireTimestamp;
    }

    public function build(): string
    {
        // 1. Pack the message body (salt + timestamp + privileges)
        $msg = $this->packContent();

        // 2. Sign: HMAC-SHA256 over appId + channelName + uid + packed message
        $toSign    = $this->appId . $this->channelName . $this->uid . $msg;
        $signature = hash_hmac('sha256', $toSign, $this->appCertificate, true);

        // 3. Concatenate message + length-prefixed signature, then deflate + base64
        $payload = $msg . $this->packString($signature);
        $compressed = zlib_encode($payload, ZLIB_ENCODING_DEFLATE);

        // 4. Final token: VERSION (3 chars) + appId (32 chars) + base64(compressed)
        return self::VERSION . $this->appId . base64_encode($compressed);
    }

    // ── Packing helpers ───────────────────────────────────────────────────────

    private function packContent(): string
    {
        // All integers are little-endian (V = uint32_le, v = uint16_le)
        $buf  = pack('V', $this->salt);
        $buf .= pack('V', $this->ts);
        $buf .= pack('v', count($this->privileges));

        foreach ($this->privileges as $key => $value) {
            $buf .= pack('v', $key);   // privilege id  (uint16_le)
            $buf .= pack('V', $value); // expire ts      (uint32_le)
        }

        return $buf;
    }

    private function packString(string $str): string
    {
        // String length prefix is big-endian uint16 (n), matching Agora spec
        return pack('n', strlen($str)) . $str;
    }
}