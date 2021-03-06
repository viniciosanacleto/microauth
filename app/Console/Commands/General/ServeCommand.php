<?php


namespace App\Console\Commands\General;


use Illuminate\Console\Command;

class ServeCommand extends Command
{
    protected $signature = "serve";

    protected $description = "Initiate PHP server on port 8000";

    public function handle(){
        echo 'Server Running on 8010'.PHP_EOL;
        exec('php -S localhost:8010 -t public >&1',$output);
        var_dump($output);
    }
}
