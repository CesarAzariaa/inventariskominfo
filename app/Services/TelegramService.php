<?php

namespace App\Services;

use GuzzleHttp\Client;

class TelegramService
{
    protected $client;
    protected $botToken;

    public function __construct()
    {
        $this->client = new Client();
        $this->botToken = config('services.telegram.bot_token'); // Mengambil bot token dari konfigurasi
    }

    public function sendMessage($chatId, $message)
    {
        $url = "https://api.telegram.org/bot{$this->botToken}/sendMessage";
        $response = $this->client->post($url, [
            'json' => [
                'chat_id' => $chatId,
                'text' => $message,
                'parse_mode' => 'HTML'
            ]
        ]);

        return $response;
    }
}
