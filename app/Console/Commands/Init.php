<?php

namespace LaterPost\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class Init extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laterpost:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for installing laterpost.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $env_path = base_path('.env');

        try {
            DB::connection();
        } catch (\Exception $e)
        {
            $this->error('Unable to connect a database.');
            $this->error('Please fill valid database credentials into .env and rerun this command. ');
            return;
        }
        $this->comment('Attempting to install laterpost');

        if(is_null(env('APP_KEY'))){
            $this->info("Generating app key");
            Artisan::call('key:generate');
        }
        else {
            $this->comment('App key exists --skipping');
        }

        if(is_null(env('JWT_SECRET')))
        {
            $this->info("Generating JWT secret");
            Artisan::call('jwt:secret');
        }
        else {
            $this->comment('JWT secret exists --skipping');
        }

        if(is_null(env('FILE_DISK')))
        {
            $default_disk = $this->choice('Please choose default filesystem disk',['local','s3']);
            File::append($env_path,PHP_EOL."FILE_DISK=$key");
            if($default_disk == "s3"){
                Artisan::call('aws:setup');
            }
        } else {
            $this->comment('File disk exists --skipping');
        }

        $this->info('Migrating database');
        Artisan::call('migrate',['--force' => true]);

        $this->info('Executing npm install and gulp');
        system('npm install');

        $this->comment("\n Success! You can now start using Laterpost form localhost with `php artisan serve`.");
    }
}
