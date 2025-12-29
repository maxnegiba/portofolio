<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GroqTranslationService
{
    protected string $apiKey;
    protected string $apiUrl = 'https://api.groq.com/openai/v1/chat/completions';
    protected string $model = 'llama-3.3-70b-versatile'; // Updated: was llama-3.1-70b-versatile (decommissioned)
    protected float $temperature = 0.3; // Lower for consistency
    protected int $maxRetries = 3;
    protected int $retryDelay = 2000; // milliseconds

    public function __construct()
    {
        $this->apiKey = config('services.groq.api_key');

        if (!$this->apiKey) {
            throw new \Exception('Groq API key not configured. Add GROQ_API_KEY to .env');
        }
    }

    /**
     * Translate text from English to target language using Groq API
     * Includes retry logic for rate limit handling
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

        $attempt = 0;
        $lastError = null;

        while ($attempt < $this->maxRetries) {
            try {
                return $this->makeTranslationRequest($text, $targetLanguage, $context);
            } catch (\Exception $e) {
                $lastError = $e;
                $attempt++;

                // Check if it's a rate limit error
                if ($this->isRateLimitError($e) && $attempt < $this->maxRetries) {
                    // Extract wait time from error if available
                    $waitTime = $this->extractWaitTimeFromError($e->getMessage());
                    $sleepMs = max($waitTime * 1000, $this->retryDelay * $attempt);
                    
                    Log::warning("Rate limit hit, retrying in {$sleepMs}ms (attempt {$attempt}/{$this->maxRetries})");
                    usleep($sleepMs * 1000);
                } else {
                    // Not a rate limit error or last attempt, throw
                    throw $e;
                }
            }
        }

        throw $lastError ?? new \Exception('Translation failed after all retries');
    }

    /**
     * Make the actual translation request to Groq API
     */
    protected function makeTranslationRequest(string $text, string $targetLanguage, string $context): string
    {
        $systemPrompt = "You are an expert translator. Translate the following text to {$targetLanguage}.";
        
        if ($context) {
            $systemPrompt .= " Context: {$context}";
        }
        
        $systemPrompt .= " Maintain the same tone and style. Only return the translated text, nothing else.";

        $response = Http::withHeaders([
            'Authorization' => "Bearer {$this->apiKey}",
            'Content-Type' => 'application/json',
        ])->timeout(30)->post($this->apiUrl, [
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
            $statusCode = $response->status();
            $body = $response->body();
            
            Log::error('Groq API Error', [
                'status' => $statusCode,
                'response' => $body,
            ]);
            
            throw new \Exception("Groq API error: {$body}");
        }

        $translated = $response->json('choices.0.message.content');

        if (!$translated) {
            throw new \Exception('No translation received from Groq API');
        }

        return trim($translated);
    }

    /**
     * Check if error is a rate limit error
     */
    protected function isRateLimitError(\Exception $e): bool
    {
        $message = $e->getMessage();
        return stripos($message, 'rate_limit') !== false || 
               stripos($message, 'rate limit') !== false ||
               stripos($message, 'tpm') !== false ||
               stripos($message, 'rpm') !== false;
    }

    /**
     * Extract wait time from Groq error message
     * Example: "Please try again in 700ms" or "Please try again in 2s"
     */
    protected function extractWaitTimeFromError(string $message): float
    {
        // Try to extract milliseconds
        if (preg_match('/try again in (\d+)ms/', $message, $matches)) {
            return $matches[1] / 1000; // Convert to seconds
        }
        
        // Try to extract seconds
        if (preg_match('/try again in ([\d.]+)s/', $message, $matches)) {
            return (float)$matches[1];
        }

        // Default wait time
        return 3; // 3 seconds
    }

    /**
     * Translate multiple texts in batch (more efficient)
     * Note: This still respects rate limits
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
            // Add delay between requests to respect rate limits
            usleep(500000); // 500ms delay
        }

        return $translations;
    }
}
