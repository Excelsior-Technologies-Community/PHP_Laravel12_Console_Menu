<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MainMenuCommand extends Command
{
    protected $signature = 'menu:main';
    protected $description = 'Interactive Laravel Console Menu';

public function handle()
{
    $this->info('====================================');
    $this->info('      Laravel 12 Console Menu       ');
    $this->info('====================================');

    while (true) {

        $choice = $this->choice(
            'Select an option',
            [
                'Show Date & Time',
                'Show Laravel Version',
                'Ask User Name',
                'Show Table Example',
                'Exit'
            ],
            0 // default selected index
        );

        switch ($choice) {
            case 'Show Date & Time':
                $this->showDateTime();
                break;

            case 'Show Laravel Version':
                $this->showLaravelVersion();
                break;

            case 'Ask User Name':
                $this->askUserName();
                break;

            case 'Show Table Example':
                $this->showTableExample();
                break;

            case 'Exit':
                $this->info('Goodbye! Have a great day!');
                return;
        }
    }
}

    private function showDateTime()
    {
        $this->line('Current Date & Time: ' . now());
    }

    private function showLaravelVersion()
    {
        $this->line('Laravel Version: ' . app()->version());
    }

    private function askUserName()
    {
        $name = $this->ask('What is your name?');
        $this->info("Hello, $name! Welcome to Laravel Console Menu.");
    }

    private function showTableExample()
    {
        $this->table(
            ['ID', 'Name'],
            [
                [1, 'Laravel'],
                [2, 'Console Menu'],
                [3, 'Artisan Command']
            ]
        );
    }
}