<?php


namespace App\Console\Commands\General;


use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class InitCommand extends Command
{
    protected $signature = "init";

    protected $description = "Initiate the configuration of Microauth service";

    public function handle()
    {
        $this->info('Initiating Microauth configurations...'.PHP_EOL);
        //Verify .env is created
        if (!file_exists(base_path() . '/.env')) {
            $this->createNewEnv();
        }

        //Run migrations
        echo shell_exec('php ' . base_path() . '/artisan ' . 'migrate');

        //Create first resource
        if ($this->confirm('Do you want to register the first application?')) {
            $sourceName = $this->ask("What's the name of the application?");
            if (!empty($sourceName)) {
                echo shell_exec('php ' . base_path() . '/artisan ' . 'auth:new-source '.$sourceName);
            } else {
                echo "No application has been registered. You can do manually with command 'php artisan auth:new-source [your_application_name]'" . PHP_EOL;
            }
        }
        echo PHP_EOL;

        $this->info("That's it. Your Microauth service is ready to run. Use the command 'php artisan serve' for your first run.");
    }

    protected function createNewEnv()
    {
        $dummy = file_get_contents(base_path() . '/app/Console/Commands/General/dummys/env.dummy');

        $dbHost = $this->ask("Database Host (127.0.0.1)?");
        if (empty($dbHost)) {
            $dbHost = '127.0.0.1';
        }
        $dummy = str_replace('{var_db_host}', $dbHost, $dummy);

        $dbPort = $this->ask("Database Port (3306)?");
        if (empty($dbPort)) {
            $dbPort = '3306';
        }
        $dummy = str_replace('{var_db_port}', $dbPort, $dummy);

        $dbDatabase = $this->ask("Database Schema (microauth)?");
        if (empty($dbDatabase)) {
            $dbDatabase = 'microauth';
        }
        $dummy = str_replace('{var_db_database}', $dbDatabase, $dummy);

        $dbUsername = $this->ask("Database Username (root)?");
        if (empty($dbUsername)) {
            $dbUsername = 'root';
        }
        $dummy = str_replace('{var_db_username}', $dbUsername, $dummy);

        $dbPassword = $this->ask("Database Password (root)?");
        if (empty($dbPassword)) {
            $dbPassword = 'root';
        }
        $dummy = str_replace('{var_db_password}', $dbPassword, $dummy);

        $authSignature = Str::random(32);
        $dummy = str_replace('{var_auth_signature}', $authSignature, $dummy);

        $tokenExpirationTime = $this->ask('Expiration time for generated tokens (in seconds)(3600)?');
        if (empty($tokenExpirationTime)) {
            $tokenExpirationTime = '3600';
        }
        $dummy = str_replace('{var_auth_expiration_time}', $tokenExpirationTime, $dummy);

        file_put_contents(base_path() . '/.env', $dummy);
    }
}
