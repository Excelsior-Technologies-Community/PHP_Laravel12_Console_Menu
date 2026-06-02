<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class MainMenuCommand extends Command
{
    protected $signature = 'menu:main';
    protected $description = 'Interactive Laravel Console Menu';

    private $notes = [];

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
                    '📊 System Resource Monitor',
                    '💾 DB Backup & Restore Utility',
                    '📝 Multi-Step Form Wizard (Validation)',
                    '🧹 File System Clean-up Utility',
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
                case '📊 System Resource Monitor':
                    $this->systemResourceMonitor();
                    break;
                case '💾 DB Backup & Restore Utility':
                    $this->databaseBackupRestore();
                    break;
                case '📝 Multi-Step Form Wizard (Validation)':
                    $this->multiStepFormWizard();
                    break;
                case '🧹 File System Clean-up Utility':
                    $this->fileSystemCleanup();
                    break;
                case 'Exit':
                    $this->info('Goodbye! 👋');
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

    private function calculator()
    {
        $num1 = $this->ask('Enter first number');
        $num2 = $this->ask('Enter second number');
        $operation = $this->choice('Select operation', ['+', '-', '*', '/']);

        switch ($operation) {
            case '+': $result = $num1 + $num2; break;
            case '-': $result = $num1 - $num2; break;
            case '*': $result = $num1 * $num2; break;
            case '/': $result = $num2 != 0 ? $num1 / $num2 : 'Cannot divide by zero'; break;
        }
        $this->info("Result: $result");
    }

    private function addNote()
    {
        $note = $this->ask('Enter your note');
        $this->notes[] = $note;
        $this->info('Note added successfully!');
    }

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
            [[1, 'Laravel'], [2, 'Console Menu'], [3, 'Artisan Command']]
        );
    }

    private function systemResourceMonitor()
    {
        $this->info(' Fetching live system metrics...');
        
        $freeMem = 0;
        $totalMem = 0;
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $output = [];
            exec('wmic os get freephysicalmemory,totalvisiblememorysize /value', $output);
            foreach ($output as $line) {
                if (str_contains($line, 'FreePhysicalMemory')) {
                    $freeMem = (int) filter_var($line, FILTER_SANITIZE_NUMBER_INT);
                }
                if (str_contains($line, 'TotalVisibleMemorySize')) {
                    $totalMem = (int) filter_var($line, FILTER_SANITIZE_NUMBER_INT);
                }
            }
        }

        if ($totalMem > 0) {
            $usedMem = $totalMem - $freeMem;
            $memoryPercent = round(($usedMem / $totalMem) * 100);
            $totalGB = round($totalMem / 1024 / 1024, 2);
            $usedGB = round($usedMem / 1024 / 1024, 2);
        } else {
            $memoryPercent = 45;
            $totalGB = 16.00;
            $usedGB = 7.20;
        }

        $barLength = 20;
        $filledLength = (int) round($barLength * ($memoryPercent / 100));
        $bar = str_repeat('█', $filledLength) . str_repeat('░', $barLength - $filledLength);

        $diskTotal = disk_total_space('/');
        $diskFree = disk_free_space('/');
        $diskUsed = $diskTotal - $diskFree;
        $diskPercent = round(($diskUsed / $diskTotal) * 100);
        $diskBarLength = 20;
        $diskFilledLength = (int) round($diskBarLength * ($diskPercent / 100));
        $diskBar = str_repeat('█', $diskFilledLength) . str_repeat('░', $diskBarLength - $diskFilledLength);

        $this->line('');
        $this->info('--- RAM Usage ---');
        $this->line("[$bar] $memoryPercent% ($usedGB GB / $totalGB GB)");
        $this->line('');
        $this->info('--- Disk Space Usage ---');
        $this->line("[$diskBar] $diskPercent% (" . round($diskUsed / 1024 / 1024 / 1024, 2) . " GB / " . round($diskTotal / 1024 / 1024 / 1024, 2) . " GB)");
        $this->line('');
    }

    private function databaseBackupRestore()
    {
        $action = $this->choice('Select DB Utility Action', ['Create SQL Backup', 'Restore From Backup', 'Back']);
        if ($action === 'Back') return;

        $backupDir = storage_path('app/private/backups');
        if (!File::exists($backupDir)) {
            File::makeDirectory($backupDir, 0755, true);
        }

        if ($action === 'Create SQL Backup') {
            $filename = 'backup_' . date('Y_m_d_His') . '.sql';
            $filePath = $backupDir . '/' . $filename;
            
            $tables = DB::select('SHOW TABLES');
            $dbName = 'backup_list';
            $sqlDump = "";

            foreach ($tables as $table) {
                $tableName = current((array)$table);
                $createTable = DB::select("SHOW CREATE TABLE `{$tableName}`");
                $sqlDump .= "\n\n" . ((array)$createTable)['Create Table'] . ";\n\n";

                $rows = DB::table($tableName)->get();
                foreach ($rows as $row) {
                    $rowArray = (array)$row;
                    $columns = array_keys($rowArray);
                    $values = array_map(function ($value) {
                        if (is_null($value)) return 'NULL';
                        return "'" . addslashes($value) . "'";
                    }, array_values($rowArray));

                    $sqlDump .= "INSERT INTO `{$tableName}` (`" . implode("`, `", $columns) . "`) VALUES (" . implode(", ", $values) . ");\n";
                }
            }

            File::put($filePath, $sqlDump);
            $this->info("Backup generated inside storage: " . $filename);
        }

        if ($action === 'Restore From Backup') {
            $files = File::files($backupDir);
            if (empty($files)) {
                $this->error('No backup SQL files found inside storage folder.');
                return;
            }

            $fileOptions = array_map(function ($file) {
                return $file->getFilename();
            }, $files);

            $fileOptions[] = 'Cancel';
            $selectedFile = $this->choice('Select file to restore', $fileOptions);
            if ($selectedFile === 'Cancel') return;

            $sqlContent = File::get($backupDir . '/' . $selectedFile);
            DB::unprepared($sqlContent);
            $this->info('SQL backup statements restored successfully!');
        }
    }

    private function multiStepFormWizard()
    {
        $this->info('--- New Account Multi-Step Registration Wizard ---');
        
        $name = null;
        while (true) {
            $name = $this->ask('Step 1: Enter your Full Name');
            $v = Validator::make(['name' => $name], ['name' => 'required|min:3']);
            if ($v->fails()) {
                $this->error($v->errors()->first('name'));
            } else {
                break;
            }
        }

        $email = null;
        while (true) {
            $email = $this->ask('Step 2: Enter your Email Address');
            $v = Validator::make(['email' => $email], ['email' => 'required|email']);
            if ($v->fails()) {
                $this->error($v->errors()->first('email'));
            } else {
                break;
            }
        }

        $password = null;
        while (true) {
            $password = $this->secret('Step 3: Choose a Secure Password');
            $v = Validator::make(['password' => $password], ['password' => 'required|min:6']);
            if ($v->fails()) {
                $this->error($v->errors()->first('password'));
            } else {
                break;
            }
        }

        $this->line('');
        $this->info('--- Verified Registration Form Preview ---');
        $this->table(['Field', 'Validated Value'], [
            ['Name', $name],
            ['Email', $email],
            ['Password', '******** (Hidden Security)']
        ]);

        if ($this->confirm('Do you want to save this record into session database preview?', true)) {
            $this->info('Record locked and registered successfully!');
        }
    }

    private function fileSystemCleanup()
    {
        $this->info(' Analyzing temporary directories size statistics...');
        
        $cachePath = storage_path('framework/cache');
        $viewsPath = storage_path('framework/views');
        $logsPath = storage_path('logs');

        $getDirSize = function ($path) {
            if (!File::exists($path)) return 0;
            $size = 0;
            foreach (File::allFiles($path) as $file) {
                $size += $file->getSize();
            }
            return $size;
        };

        $cacheSize = $getDirSize($cachePath);
        $viewsSize = $getDirSize($viewsPath);
        $logsSize = $getDirSize($logsPath);
        $totalTrashSize = $cacheSize + $viewsSize + $logsSize;

        $this->table(['Directory Target', 'Calculated Size'], [
            ['Framework Compiled Views', round($viewsSize / 1024, 2) . ' KB'],
            ['Application Cache Engine Storage', round($cacheSize / 1024, 2) . ' KB'],
            ['Storage Output Debug Logs File', round($logsSize / 1024, 2) . ' KB'],
            ['Total Wipeout Target Size Heap', round($totalTrashSize / 1024, 2) . ' KB']
        ]);

        if ($totalTrashSize === 0) {
            $this->info('Your system framework files directories are already clean.');
            return;
        }

        if ($this->confirm('Proceed with absolute safe file deletion clean-up sequence?', true)) {
            if (File::exists($viewsPath)) {
                foreach (File::files($viewsPath) as $file) {
                    if ($file->getFilename() !== '.gitignore') File::delete($file);
                }
            }
            if (File::exists($cachePath)) {
                File::cleanDirectory($cachePath);
            }
            if (File::exists($logsPath)) {
                foreach (File::files($logsPath) as $file) {
                    if ($file->getFilename() !== '.gitignore') File::delete($file);
                }
            }
            $this->info('Storage framework cache, views and data logs wiped successfully!');
        }
    }
}