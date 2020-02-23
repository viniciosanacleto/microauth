<?php


namespace App\Console\Commands\Auth;


use App\Models\Source;
use Illuminate\Console\Command;

class CreateSourceCommand extends Command
{
    protected $signature = "auth:new-source {name}";

    protected $description = "Create a new token for a source";

    public function handle(){
        $newSource = Source::create(['name'=> $this->argument('name')]);
        echo "\e[0;31mAtention! This token is secret, save it in a secure place.\e[0m".PHP_EOL;
        echo "\e[0;31mAuthentication Token: ".$newSource['token']."\e[0m".PHP_EOL;

    }
}
