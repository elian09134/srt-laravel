<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GroqAiService
{
    protected $apiKey;
    protected $apiUrl = 'https://api.groq.com/openai/v1/chat/completions';
    protected $model;

    public function __construct()
    {
        $this->apiKey = env('GROQ_API_KEY');
        $this->model = env('GROQ_MODEL', 'llama3-8b-8192');
    }

    public function analyzeCandidates($jobTitle, $jobRequirements, $candidates)
    {
        $systemPrompt = "You are an expert HR Technical Recruiter AI. Your task is to analyze a list of candidates against a job description.
You MUST respond with purely a valid JSON array of objects. Do not include any conversational text, markdown formatting like ```json, or explanations outside the JSON.
Format of output array:
[
  {
    \"id\": candidate_id_as_integer,
    \"match_score\": integer_0_to_100_indicating_fit,
    \"reasoning\": \"1 short sentence explaining why they are a fit or not (in Indonesian)\"
  }
]

Analyze strictly based on skills, experience, and education.";

        $userPrompt = "Job Title: " . $jobTitle . "\n";
        $userPrompt .= "Requirements: " . $jobRequirements . "\n\n";
        $userPrompt .= "Candidates (JSON):\n" . json_encode($candidates) . "\n\n";
        $userPrompt .= "Return ONLY the JSON array of evaluated candidates, sorted by highest match_score first. Limit to top 5 candidates if there are more than 5.";

        try {
            $response = Http::withToken($this->apiKey)
                ->timeout(20)
                ->post($this->apiUrl, [
                    'model' => $this->model,
                    'messages' => [
                        ['role' => 'system', 'content' => $systemPrompt],
                        ['role' => 'user', 'content' => $userPrompt],
                    ],
                    'temperature' => 0.1, // Low temp for more deterministic JSON
                ]);

            if ($response->successful()) {
                $content = $response->json('choices.0.message.content');
                
                // CRITICAL DEBUG: Log what Groq actually responded
                Log::info('GROQ RAW RESPONSE: ' . $content);
                
                // Clean up any potential markdown wrapping from LLM
                $content = str_replace(['```json', '```'], '', trim($content));
                
                $decoded = json_decode($content, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    Log::error('GROQ JSON ERROR: ' . json_last_error_msg());
                }
                
                return $decoded;
            }

            Log::error('Groq API Error: ' . $response->body());
            return [];
        } catch (\Exception $e) {
            Log::error('Groq API Exception: ' . $e->getMessage());
            return [];
        }
    }
}
