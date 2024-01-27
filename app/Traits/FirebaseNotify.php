<?php

namespace App\Traits;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

trait FirebaseNotify
{
    /**
     * Notify specific tokens using Firebase.
     */
    public function notify(string|array $tokens, string $title = '', string $body = '', array $data = []): Response
    {
        $fields = [
            'data' => $data,
            'notification' => ['title' => $title, 'body' => $body],
        ];

        $key = is_array($tokens) ? 'registration_ids' : 'to';
        $fields[$key] = $tokens;

        $client = Http::withHeaders([
            'Content-Type: application/json',
            'Authorization: key=' . env('FIREBASE_SERVER_KEY'),
        ]);

        return $client->post('https://fcm.googleapis.com/fcm/send', $fields);
    }
}
