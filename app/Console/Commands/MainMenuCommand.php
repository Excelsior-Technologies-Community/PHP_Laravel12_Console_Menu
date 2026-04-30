<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MainMenuCommand extends Command
{
    protected $signature = 'menu:main';
    protected $description = 'Interactive Laravel Console Menu';

    private $notes = []; // store notes in memory

    public function handle()
    {
        $this->info('====================================');
        $this->info('   Laravel 12 Advanced Console Menu ');
        $this->info('====================================');

        while (true) {

            $choice = $this->choice(
                'Select an option',
                [
                    'Show Date & Time',
                    'Show Laravel Version',
                    'Ask User Name',
                    'Calculator',
                    'Add Note',
                    'View Notes',
                    'Search Item',
                    'Show Table Example',
                    'Exit'
                ],
                0
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

                case 'Calculator':
                    $this->calculator();
                    break;

                case 'Add Note':
                    $this->addNote();
                    break;

                case 'View Notes':
                    $this->viewNotes();
                    break;

                case 'Search Item':
                    $this->searchItem();
                    break;

                case 'Show Table Example':
                    $this->showTableExample();
                    break;

                case 'Exit':
                    $this->info('Goodbye! 🚀');
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
        $this->info("Hello, $name! 👋 Welcome!");
    }

    // 🔥 Calculator Feature
    private function calculator()
    {
        $num1 = $this->ask('Enter first number');
        $num2 = $this->ask('Enter second number');

        $operation = $this->choice('Select operation', ['+', '-', '*', '/']);

        switch ($operation) {
            case '+':
                $result = $num1 + $num2;
                break;
            case '-':
                $result = $num1 - $num2;
                break;
            case '*':
                $result = $num1 * $num2;
                break;
            case '/':
                $result = $num2 != 0 ? $num1 / $num2 : 'Cannot divide by zero';
                break;
        }

        $this->info("Result: $result");
    }

    // 🔥 Add Note
    private function addNote()
    {
        $note = $this->ask('Enter your note');
        $this->notes[] = $note;

        $this->info('Note added successfully!');
    }

    // 🔥 View Notes
    private function viewNotes()
    {
        if (empty($this->notes)) {
            $this->error('No notes found!');
            return;
        }

        foreach ($this->notes as $index => $note) {
            $this->line(($index + 1) . '. ' . $note);
        }
    }

    // 🔥 Search Feature
    private function searchItem()
    {
        $items = ['Pizza', 'Burger', 'Pasta', 'Sandwich'];

        $search = $this->ask('Enter item to search');

        $results = array_filter($items, function ($item) use ($search) {
            return stripos($item, $search) !== false;
        });

        if (empty($results)) {
            $this->error('No items found!');
        } else {
            foreach ($results as $item) {
                $this->info($item);
            }
        }
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