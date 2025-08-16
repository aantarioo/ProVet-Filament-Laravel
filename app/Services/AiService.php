<?php

namespace App\Services;

use OpenAI\Laravel\Facades\OpenAI;

class AiService
{
    public function getAdvice(string $question): string
    {
        $response = OpenAI::chat()->create([
           'model' => 'gpt-4o-mini',
           'messages' => [
             ['role' => 'system', 'content' => 'You are a veterinary assistant. Answer concisely.'],
             ['role' => 'user', 'content' => $question],
           ],
        ]);

        return $response->choices[0]->message->content ?? 'Sorry, no response.';
    }
}
