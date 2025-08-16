<?php

namespace App\Filament\Widgets;

use App\Services\AiService;
use Filament\Widgets\Widget;

class AiAssistant extends Widget
{
    protected static string $view = 'filament.widgets.ai-assistant';

    public string $question = '';
    public string $answer = '';

    public function ask(AiService $aiService)
    {
        $this->answer = $aiService->getAdvice($this->question);
    }
}
