<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class RegistrationControl extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'registration:control {action : enable/disable registration} {--type=all : all/speaker/delegate}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enable or disable registration forms';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $action = $this->argument('action');
        $type = $this->option('type');
        
        if (!in_array($action, ['enable', 'disable'])) {
            $this->error('Action must be either "enable" or "disable"');
            return 1;
        }

        $envPath = base_path('.env');
        
        if (!File::exists($envPath)) {
            $this->error('.env file not found');
            return 1;
        }

        $envContent = File::get($envPath);
        
        $enabled = $action === 'enable' ? 'true' : 'false';

        switch ($type) {
            case 'speaker':
                $envContent = $this->updateEnvValue($envContent, 'SPEAKER_REGISTRATION_ENABLED', $enabled);
                $this->info("Speaker registration has been {$action}d");
                break;
                
            case 'delegate':
                $envContent = $this->updateEnvValue($envContent, 'DELEGATE_REGISTRATION_ENABLED', $enabled);
                $this->info("Delegate registration has been {$action}d");
                break;
                
            case 'all':
            default:
                $envContent = $this->updateEnvValue($envContent, 'REGISTRATION_ENABLED', $enabled);
                $this->info("All registration has been {$action}d");
                break;
        }

        File::put($envPath, $envContent);
        
        $this->call('config:clear');
        $this->info('Configuration cache cleared');
        
        return 0;
    }

    /**
     * Update environment value
     */
    private function updateEnvValue($envContent, $key, $value)
    {
        $pattern = "/^{$key}=.*$/m";
        $replacement = "{$key}={$value}";
        
        if (preg_match($pattern, $envContent)) {
            return preg_replace($pattern, $replacement, $envContent);
        } else {
            return $envContent . "\n{$replacement}";
        }
    }
}
