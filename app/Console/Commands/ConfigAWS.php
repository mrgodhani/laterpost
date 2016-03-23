<?php

namespace LaterPost\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ConfigAWS extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'aws:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Configure aws environment variable';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $env_path = base_path('.env');
        if(is_null(env('AMAZON_KEY'))){

            // Setup Key
            $key = $this->ask("Enter your Amazon AWS key ");
            File::append($env_path,PHP_EOL."AMAZON_KEY=$key");

            // Setup secret
            $secret=  $this->ask("Enter your Amazon AWS secret");
            File::append($env_path,PHP_EOL."AMAZON_SECRET=$secret");

            // Setup Bucket
            $bucket = $this->ask("Enter default Amazon bucket");
            File::append($env_path,PHP_EOL."AMAZON_BUCKET=$bucket");

            // Setup AWS Region
            $region =  $this->ask("Enter default AWS region");
            File::append($env_path,PHP_EOL."AMAZON_REGION=$region");

            $this->comment("All done!");
        } else {
            $this->comment("AWS config is already added. --skipping");
        }
    }
}
