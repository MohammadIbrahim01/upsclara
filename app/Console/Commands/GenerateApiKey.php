<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenerateApiKey extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:generate-key {name?} {--length=32}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a new API key for external clients';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name') ?? 'Client';
        $length = $this->option('length');

        // Generate a secure random API key
        $apiKey = 'ak_' . Str::random($length);

        $this->info('🔑 API Key Generated Successfully!');
        $this->line('');
        $this->line("Client Name: <comment>{$name}</comment>");
        $this->line("API Key: <comment>{$apiKey}</comment>");
        $this->line('');

        $this->info('📋 Next Steps:');
        $this->line('1. Add this key to your .env file:');
        $this->line("   <comment>API_KEY={$apiKey}</comment>");
        $this->line('   or add to multiple keys:');
        $this->line("   <comment>API_KEYS=existing_key,{$apiKey}</comment>");
        $this->line('');
        $this->line('2. Enable API key requirement:');
        $this->line('   <comment>REQUIRE_API_KEY=true</comment>');
        $this->line('');
        $this->line('3. Optionally enable usage logging:');
        $this->line('   <comment>LOG_API_USAGE=true</comment>');
        $this->line('');

        $this->info('🌐 Usage Examples:');
        $this->line('Header: <comment>X-API-Key: ' . $apiKey . '</comment>');
        $this->line('Bearer: <comment>Authorization: Bearer ' . $apiKey . '</comment>');
        $this->line('Query: <comment>?api_key=' . $apiKey . '</comment>');

        return Command::SUCCESS;
    }
}
