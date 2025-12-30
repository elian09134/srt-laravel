<?php

namespace App\Http\Controllers\AI;

use App\Http\Controllers\Controller;
use App\Services\GroqAgentService;
use Illuminate\Http\Request;

class AgentController extends Controller
{
    protected GroqAgentService $service;

    public function __construct(GroqAgentService $service)
    {
        $this->service = $service;
    }

    public function query(Request $request)
    {
        $data = $request->validate([
            'message' => 'required|string|max:5000',
        ]);

        // build messages array for Groq; adjust shape per API expectations
        $messages = [
            ['role' => 'user', 'content' => $data['message']],
        ];

        $result = $this->service->chat($messages);

        return response()->json($result);
    }
}
