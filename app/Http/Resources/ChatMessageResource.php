<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatMessageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'               => $this->id,
            'session_id'       => $this->session_id,
            'is_system_message'=> (bool) $this->is_system_message,

            'sender' => $this->when(
                ! $this->is_system_message,
                fn () => $this->whenLoaded('sender', fn () => [
                    'id'     => $this->sender->id,
                    'name'   => $this->sender->name,
                    'role'   => $this->sender->role->value,
                    'avatar' => $this->sender->profile_photo_url ?? null,
                ])
            ),

            'message'     => $this->message,
            'attachments' => $this->attachments ?? [],

            'timestamps' => [
                'sent_at'      => $this->created_at?->toIso8601String(),
                'delivered_at' => $this->delivered_at?->toIso8601String(),
                'read_at'      => $this->read_at?->toIso8601String(),
            ],

            // Computed read state for the requesting user
            'is_read'    => $this->read_at !== null,
            'is_own'     => $request->user()?->id === $this->sender_id,
        ];
    }
}