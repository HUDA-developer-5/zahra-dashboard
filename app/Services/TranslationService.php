<?php

namespace App\Services;

use App\Models\Advertisement;
use GuzzleHttp\Client;

class TranslationService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('OPENAI_API_KEY');
    }

    public function translate($text, $targetLanguage)
    {
        try {
            $prompt = "Translate the following text to {$targetLanguage}: {$text}";
            $response = $this->client->post('https://api.openai.com/v1/chat/completions', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'model' => 'gpt-3.5-turbo',
                    'messages' => [
                        ['role' => 'system', 'content' => 'You are a translator.'],
                        ['role' => 'user', 'content' => $prompt],
                    ],
                    'max_tokens' => 100,
                ]
            ]);

            $result = json_decode($response->getBody(), true);
            return trim($result['choices'][0]['message']['content']) ?? null;
        } catch (\Exception $exception) {
            return null;
        }
    }

    public function translateProduct(Advertisement $product)
    {
        $translatedDescription = null;
        $locales = ['ar', 'en'];
        $translations = $product->getTranslations('description');
        foreach ($locales as $locale) {
            if (!key_exists($locale, $translations)) {
                $translatedDescription = $this->translate($product->description, $locale);
                $product->setTranslation('description', $locale, $translatedDescription);
            }
        }
        $product->save();
        if (!$translatedDescription) {
            $translatedDescription = $this->translate($product->description, (app()->getLocale() == 'ar') ? 'en' : 'ar');
        }
        return $translatedDescription;
    }
}