<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GroqAgentService
{
    /**
     * Send chat messages to Groq and return response.
     * @param array $messages Array of message objects or single string message
     * @return array|null
     */
    public function chat(array $messages)
    {
        $url = env('GROQ_API_URL');
        $key = env('GROQ_API_KEY');

        if (! $url || ! $key) {
            return ['error' => 'Groq API not configured'];
        }

        try {
            $payload = [
                'messages' => $messages,
                // adjust model/params as required by your Groq plan
                'model' => env('GROQ_MODEL', 'groq-1'),
                'temperature' => floatval(env('GROQ_TEMPERATURE', 0.2)),
            ];

            $response = Http::withToken($key)
                ->timeout(30)
                ->post($url, $payload);

            if ($response->failed()) {
                return ['error' => 'API request failed', 'status' => $response->status(), 'body' => $response->body()];
            }

            return $response->json();
        } catch (\Exception $e) {
            return ['error' => 'Exception: '.$e->getMessage()];
        }
    }
}
