<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GroqTranslationService
{
    protected string $apiKey;
    protected string $apiUrl = 'https://api.groq.com/openai/v1/chat/completions';
    protected string $model = 'llama-3.1-70b-versatile';
    protected float $temperature = 0.3; // Lower for consistency

    public function __construct()
    {
        $this->apiKey = config('services.groq.api_key');

        if (!$this->apiKey) {
            throw new \Exception('Groq API key not configured. Add GROQ_API_KEY to .env');
        }
    }

    /**
     * Translate text from English to target language using Groq API
     *
     * @param string $text Text to translate
     * @param string $targetLanguage Target language code (e.g., 'vitameza', 'ro', 'vi')
     * @param string $context Optional context for better translation
     * @return string Translated text
     */
    public function translate(string $text, string $targetLanguage = 'vitameza', string $context = ''): string
    {
        if (empty($text)) {
            return '';
        }

        try {
            $systemPrompt = "You are an expert translator. Translate the following text to {$targetLanguage}.";
            
            if ($context) {
                $systemPrompt .= " Context: {$context}";
            }
            
            $systemPrompt .= " Maintain the same tone and style. Only return the translated text, nothing else.";

            $response = Http::withHeaders([
                'Authorization' => "Bearer {$this->apiKey}",
                'Content-Type' => 'application/json',
            ])->post($this->apiUrl, [
                'model' => $this->model,
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => $systemPrompt,
                    ],
                    [
                        'role' => 'user',
                        'content' => "Translate this text:\n\n{$text}",
                    ],
                ],
                'temperature' => $this->temperature,
                'max_tokens' => 2000,
            ]);

            if ($response->failed()) {
                Log::error('Groq API Error', [
                    'status' => $response->status(),
                    'response' => $response->body(),
                ]);
                throw new \Exception("Groq API error: {$response->body()}");
            }

            $translated = $response->json('choices.0.message.content');

            if (!$translated) {
                throw new \Exception('No translation received from Groq API');
            }

            return trim($translated);
        } catch (\Exception $e) {
            Log::error('Translation Error', [
                'message' => $e->getMessage(),
                'text' => substr($text, 0, 100),
            ]);
            throw $e;
        }
    }

    /**
     * Translate multiple texts in batch (more efficient)
     *
     * @param array $texts Array of texts to translate
     * @param string $targetLanguage Target language code
     * @return array Translated texts in same order
     */
    public function translateBatch(array $texts, string $targetLanguage = 'vitameza'): array
    {
        $translations = [];

        foreach ($texts as $text) {
            $translations[] = $this->translate($text, $targetLanguage);
            // Add small delay to respect rate limits
            usleep(200000); // 200ms delay
        }

        return $translations;
    }
}
