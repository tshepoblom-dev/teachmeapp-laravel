<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FcmTokenController extends Controller
{
    /**
     * Store or refresh the authenticated user's FCM token.
     *
     * Called by the mobile/web client on login or when the token rotates.
     * POST /fcm-token  { token: "..." }
     */
  /*  public function store(Request $request): JsonResponse
    {
        $request->validate([
            'token' => ['required', 'string', 'max:500'],
        ]);

        $request->user()->update(['fcm_token' => $request->token]);

        return response()->json(['message' => 'FCM token saved.']);
    }*/

    public function store(Request $request)
    {
        $request->validate(['token' => 'required|string|max:500']);

        $request->user()->update(['fcm_token' => $request->token]);

        return response()->json(['status' => 'ok']);
    }

    /**
     * Clear the token on logout so the device stops receiving pushes.
     * DELETE /fcm-token
     */
    public function destroy(Request $request): JsonResponse
    {
        $request->user()->update(['fcm_token' => null]);

        return response()->json(['message' => 'FCM token cleared.']);
    }
}