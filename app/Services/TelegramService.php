<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramService
{
    private ?string $botToken;
    private ?string $chatId;

    public function __construct()
    {
        $this->botToken = config('services.telegram.bot_token') ?? env('TELEGRAM_BOT_TOKEN');
        $this->chatId = config('services.telegram.chat_id') ?? env('TELEGRAM_CHAT_ID');
    }

    /**
     * Send a message to Telegram
     */
    public function sendMessage(string $message, ?string $chatId = null): bool
    {
        $chatId = $chatId ?? $this->chatId;

        if (!$this->botToken || !$chatId) {
            Log::warning('Telegram bot token or chat ID not configured');
            return false;
        }

        try {
            $response = Http::post("https://api.telegram.org/bot{$this->botToken}/sendMessage", [
                'chat_id' => $chatId,
                'text' => $message,
                'parse_mode' => 'HTML',
            ]);

            if ($response->successful()) {
                return true;
            }

            Log::error('Telegram API error', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return false;
        } catch (\Exception $e) {
            Log::error('Telegram send message failed', ['error' => $e->getMessage()]);
            return false;
        }
    }

    /**
     * Send notification about a new regret
     */
    public function notifyNewRegret($regret): bool
    {
        $content = mb_substr($regret->content, 0, 500);
        if (mb_strlen($regret->content) > 500) {
            $content .= '...';
        }

        $message = "🆕 <b>پشیمانی جدید</b>\n\n";
        $message .= htmlspecialchars($content, ENT_QUOTES, 'UTF-8');
        $message .= "\n\n";
        $message .= "🔗 <a href=\"" . route('regrets.show', $regret) . "\">مشاهده</a>";

        return $this->sendMessage($message);
    }

    /**
     * Send notification about a new comment
     */
    public function notifyNewComment($comment, $regret): bool
    {
        $commentContent = mb_substr($comment->content, 0, 300);
        if (mb_strlen($comment->content) > 300) {
            $commentContent .= '...';
        }

        $regretContent = mb_substr($regret->content, 0, 200);
        if (mb_strlen($regret->content) > 200) {
            $regretContent .= '...';
        }

        $message = "💬 <b>نظر جدید</b>\n\n";
        $message .= "<b>پشیمانی:</b>\n";
        $message .= htmlspecialchars($regretContent, ENT_QUOTES, 'UTF-8');
        $message .= "\n\n";
        $message .= "<b>نظر:</b>\n";
        $message .= htmlspecialchars($commentContent, ENT_QUOTES, 'UTF-8');
        $message .= "\n\n";
        $message .= "🔗 <a href=\"" . route('regrets.show', $regret) . "\">مشاهده</a>";

        return $this->sendMessage($message);
    }

    /**
     * Get updates from Telegram (to find chat ID)
     */
    public function getUpdates(): array
    {
        if (!$this->botToken) {
            return [];
        }

        try {
            $response = Http::get("https://api.telegram.org/bot{$this->botToken}/getUpdates");

            if ($response->successful()) {
                return $response->json('result', []);
            }

            return [];
        } catch (\Exception $e) {
            Log::error('Telegram get updates failed', ['error' => $e->getMessage()]);
            return [];
        }
    }
}

