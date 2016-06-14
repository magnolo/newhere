<?php

namespace App\Console\Commands\Translations;

use Illuminate\Console\Command;

class Help extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translations:help';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prints all required information about handling translations';

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
        $text = file_get_contents(__DIR__ . '/help.txt');
        $this->info($text);
    }
}
