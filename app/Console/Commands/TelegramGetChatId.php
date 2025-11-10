<?php

namespace App\Console\Commands;

use App\Services\TelegramService;
use Illuminate\Console\Command;

class TelegramGetChatId extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:get-chat-id';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get your Telegram chat ID by sending a message to the bot first';

    /**
     * Execute the console command.
     */
    public function handle(TelegramService $telegram)
    {
        $this->info('Fetching updates from Telegram...');
        $this->info('Make sure you have sent a message to your bot first!');
        $this->newLine();

        $updates = $telegram->getUpdates();

        if (empty($updates)) {
            $this->error('No updates found. Please send a message to your bot first.');
            $this->info('1. Open Telegram and find your bot');
            $this->info('2. Send any message (e.g., /start)');
            $this->info('3. Run this command again');
            return 1;
        }

        $this->info('Found ' . count($updates) . ' update(s):');
        $this->newLine();

        foreach ($updates as $update) {
            $message = $update['message'] ?? null;
            if ($message) {
                $chat = $message['chat'];
                $chatId = $chat['id'];
                $chatType = $chat['type'] ?? 'unknown';
                $chatTitle = $chat['title'] ?? $chat['first_name'] ?? 'Unknown';

                $this->line("Chat ID: <fg=green>{$chatId}</>");
                $this->line("Type: {$chatType}");
                $this->line("Name: {$chatTitle}");
                $this->newLine();
            }
        }

        $this->info('Add this chat ID to your .env file:');
        $this->line('TELEGRAM_CHAT_ID=YOUR_CHAT_ID_HERE');
        
        return 0;
    }
}
