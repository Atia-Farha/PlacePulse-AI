<?php

namespace App\Services;

use OpenAI\Laravel\Facades\OpenAI;
use Illuminate\Support\Facades\Log;

class OpenAIReportService
{
    /**
     * The JSON schema that GPT must follow for structured output.
     */
    private function getResponseSchema(): array
    {
        return [
            'type' => 'json_schema',
            'json_schema' => [
                'name' => 'location_report',
                'strict' => true,
                'schema' => [
                    'type' => 'object',
                    'properties' => [
                        'title' => [
                            'type' => 'string',
                            'description' => 'A catchy, creative title for this location report',
                        ],
                        'subtitle' => [
                            'type' => 'string',
                            'description' => 'A short poetic subtitle or tagline (max 15 words)',
                        ],
                        'soul' => [
                            'type' => 'string',
                            'description' => 'The Soul of the Place: a 300-400 word engaging narrative',
                        ],
                        'history' => [
                            'type' => 'array',
                            'description' => '3-5 hidden history moments with fresh angles',
                            'items' => [
                                'type' => 'object',
                                'properties' => [
                                    'year' => [
                                        'type' => 'string',
                                        'description' => 'Year or era of the event',
                                    ],
                                    'title' => [
                                        'type' => 'string',
                                        'description' => 'Short title of the historical moment',
                                    ],
                                    'description' => [
                                        'type' => 'string',
                                        'description' => 'Engaging 2-3 sentence description with a fresh angle',
                                    ],
                                ],
                                'required' => ['year', 'title', 'description'],
                                'additionalProperties' => false,
                            ],
                        ],
                        'must_visit' => [
                            'type' => 'array',
                            'description' => '5-7 curated must-visit spots nearby',
                            'items' => [
                                'type' => 'object',
                                'properties' => [
                                    'name' => [
                                        'type' => 'string',
                                        'description' => 'Name of the place',
                                    ],
                                    'category' => [
                                        'type' => 'string',
                                        'description' => 'Category like Museum, Park, Market, etc.',
                                    ],
                                    'description' => [
                                        'type' => 'string',
                                        'description' => 'Short vivid description (1-2 sentences)',
                                    ],
                                    'why_visit' => [
                                        'type' => 'string',
                                        'description' => 'A compelling reason to visit (1 sentence)',
                                    ],
                                ],
                                'required' => ['name', 'category', 'description', 'why_visit'],
                                'additionalProperties' => false,
                            ],
                        ],
                        'local_flavors' => [
                            'type' => 'array',
                            'description' => '4-6 local food, culture, and unique experience items',
                            'items' => [
                                'type' => 'object',
                                'properties' => [
                                    'title' => [
                                        'type' => 'string',
                                        'description' => 'Name of the experience or food',
                                    ],
                                    'type' => [
                                        'type' => 'string',
                                        'description' => 'Category: Food, Culture, Activity, or Nightlife',
                                    ],
                                    'description' => [
                                        'type' => 'string',
                                        'description' => 'Vivid 1-2 sentence description',
                                    ],
                                ],
                                'required' => ['title', 'type', 'description'],
                                'additionalProperties' => false,
                            ],
                        ],
                        'practical_tips' => [
                            'type' => 'array',
                            'description' => '5-7 practical travel tips',
                            'items' => [
                                'type' => 'object',
                                'properties' => [
                                    'category' => [
                                        'type' => 'string',
                                        'description' => 'Category of the tip: timing, etiquette, budget, safety, transport, other',
                                    ],
                                    'tip' => [
                                        'type' => 'string',
                                        'description' => 'The practical tip (1-2 sentences)',
                                    ],
                                ],
                                'required' => ['category', 'tip'],
                                'additionalProperties' => false,
                            ],
                        ],
                        'fun_facts' => [
                            'type' => 'array',
                            'description' => '4-6 fun facts and trivia about this place',
                            'items' => [
                                'type' => 'string',
                            ],
                        ],
                    ],
                    'required' => [
                        'title',
                        'subtitle',
                        'soul',
                        'history',
                        'must_visit',
                        'local_flavors',
                        'practical_tips',
                        'fun_facts',
                    ],
                    'additionalProperties' => false,
                ],
            ],
        ];
    }

    /**
     * Build the system prompt for the AI.
     */
    private function getSystemPrompt(): string
    {
        return <<<'PROMPT'
You are PlacePulse AI — a world-class travel writer, historian, and cultural guide rolled into one.

When given a location (city, neighborhood, landmark, or coordinates), you produce an incredibly engaging, informative, and beautifully written location report.

Your writing style:
- Vivid, sensory language that makes readers feel like they're standing there
- Mix of poetic prose and punchy facts
- Fresh angles on well-known places — avoid clichés and generic tourist guide language
- Include lesser-known stories that locals would appreciate
- Be specific — mention real street names, dishes, traditions, landmarks
- Warm, enthusiastic tone without being over-the-top
- CRITICAL: Do NOT use any emojis anywhere in the response text, titles, subtitles, or details. Keep it purely text-based.

Guidelines for each section:
1. **title**: Creative, catchy — like a magazine feature headline
2. **subtitle**: A poetic one-liner that captures the place's essence
3. **soul**: 300-400 words of immersive narrative — paint the atmosphere, sounds, smells, energy
4. **history**: 3-5 pivotal moments, but with FRESH angles — the untold stories, not the Wikipedia summary
5. **must_visit**: 5-7 curated spots — mix iconic and hidden gems, with specific reasons to visit
6. **local_flavors**: 4-6 food/culture/activity items — be specific about dish names, traditions, experiences
7. **practical_tips**: 5-7 genuinely useful tips a first-time visitor needs — timing, etiquette, money-saving, safety. Specify categories accurately: timing, etiquette, budget, safety, transport, other.
8. **fun_facts**: 4-6 surprising, delightful facts that make people say "I had no idea!"

IMPORTANT: Always respond with valid JSON matching the required schema. Every field must be present and properly formatted.
IMPORTANT: Write the entire report in English only, regardless of the location's local language or script.
PROMPT;
    }

    /**
     * Generate a location report using OpenAI.
     */
    public function generateReport(string $location): array
    {
        $model = config('openai.model', 'gpt-5-mini');
        $maxTokens = (int) config('openai.max_completion_tokens', 8000);

        try {
            $payload = [
                'model' => $model,
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => $this->getSystemPrompt(),
                    ],
                    [
                        'role' => 'user',
                        'content' => "Generate a comprehensive location report for: {$location}",
                    ],
                ],
                'response_format' => $this->getResponseSchema(),
                'max_completion_tokens' => $maxTokens,
            ];

            if ($reasoningEffort = config('openai.reasoning_effort')) {
                $payload['reasoning_effort'] = $reasoningEffort;
            }

            $response = OpenAI::chat()->create($payload);

            $choice = $response->choices[0];
            $content = $choice->message->content;

            if ($content === null || $content === '') {
                $finishReason = $choice->finishReason ?? 'unknown';
                throw new \RuntimeException(
                    "AI returned empty content (finish_reason: {$finishReason}). "
                    . 'Try increasing OPENAI_MAX_COMPLETION_TOKENS or lowering reasoning effort.'
                );
            }

            $data = json_decode($content, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \RuntimeException('Failed to parse AI response as JSON: ' . json_last_error_msg());
            }

            return $data;

        } catch (\Exception $e) {
            Log::error('OpenAI Report Generation Failed', [
                'location' => $location,
                'error' => $e->getMessage(),
            ]);

            throw $e;
        }
    }
}
