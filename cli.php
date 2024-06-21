#!/usr/bin/env php
<?php

require_once __DIR__ . '/vendor/autoload.php';

class CLI {
    public function run() {
        global $argv;
        $command = $argv[1] ?? null;

        switch ($command) {
            case 'make:template':
                $this->makeTemplate($argv[2] ?? null);
                break;
            case 'make:page':
                $this->makePage($argv[2] ?? null);
                break;
            case 'serve':
                $this->serve();
                break;
            case 'make:migration':
                $this->makeMigration($argv[2] ?? null);
                break;
            case 'migrate':
                $this->migrate();
                break;
            default:
                $this->showHelp();
                break;
        }
    }

    private function makeTemplate($name) {
        if (!$name) {
            echo "Please provide a template name.\n";
            return;
        }

        $templatePath = __DIR__ . "/templates/{$name}_template.php";

        if (file_exists($templatePath)) {
            echo "Template '{$name}' already exists.\n";
            return;
        }

        $content = <<<PHP
                        <?php ob_start(); ?>
                        <!-- Your template content here -->
                        <span>Template content.</span>
                        <?php require 'layout.php'; ?>
                        <?php \$content = ob_get_clean(); ?>
                        <?php require 'layout.php'; ?>
                        PHP;

        file_put_contents($templatePath, $content);
        echo "Template '{$name}' created successfully.\n";
    }

    private function makePage($name) {
        if (!$name) {
            echo "Please provide a page name.\n";
            return;
        }

        $pagePath = __DIR__ . "/pages/{$name}.php";

        if (file_exists($pagePath)) {
            echo "Page '{$name}' already exists.\n";
            return;
        }

        $content = <<<PHP
                        <?php

                        require_once __DIR__ . '/../classes/Controller.php';

                        class {$name}Controller extends Controller {
                            public function index() {
                                \$this->view('{$name}_template', ['title' => '{$name}']);
                            }
                        }
                        PHP;

        file_put_contents($pagePath, $content);
        echo "Page '{$name}' created successfully.\n";
    }

    private function makeMigration($name) {
        if (!$name) {
            echo "Please provide a migration name.\n";
            return;
        }

        $timestamp = date('YmdHis');
        $migrationPath = __DIR__ . "/db/migrations/{$timestamp}_{$name}.php";

        if (file_exists($migrationPath)) {
            echo "Migration '{$name}' already exists.\n";
            return;
        }

        $content = <<<PHP
                        <?php

                        use Classes\Migration;
                        use Config\Database;

                        require_once __DIR__ . '/../db_connect.php';

                        \$migration = new Migration(\$pdo);

                        // Define your table and columns
                        \$table = 'your_table_name';
                        \$columns = [
                            'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
                            'name' => 'VARCHAR(255) NOT NULL',
                            'created_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
                        ];

                        // Run the migration
                        \$migration->createTable(\$table, \$columns);
                        PHP;

        file_put_contents($migrationPath, $content);
        echo "Migration '{$name}' created successfully.\n";
    }

    private function migrate() {
        echo "Running migrations...\n";

        $migrationsDir = __DIR__ . "/db/migrations";
        $migrationFiles = glob($migrationsDir . "/*.php");

        foreach ($migrationFiles as $file) {
            require_once $file;
            echo "Migrated: " . basename($file) . "\n";
        }

        echo "All migrations executed.\n";
    }

    private function serve() {
        echo "Starting development server with hot reloading...\n";

        $phpServerCommand = 'php -S localhost:8000 -t sam/public sam/public/index.php';
        $browserSyncCommand = 'npm run serve';

        // Start the PHP built-in server
        $phpProcess = proc_open($phpServerCommand, [
            0 => ['pipe', 'r'],
            1 => ['pipe', 'w'],
            2 => ['pipe', 'w']
        ], $phpPipes);

        // Start BrowserSync
        $browserSyncProcess = proc_open($browserSyncCommand, [
            0 => ['pipe', 'r'],
            1 => ['pipe', 'w'],
            2 => ['pipe', 'w']
        ], $browserSyncPipes);

            if (is_resource($phpProcess) && is_resource($browserSyncProcess)) {
            echo "Server running at http://localhost:8000\n";
            echo "Press Ctrl+C to stop the server.\n";

            // Keep the script running to manage child processes
            while (true) {
                $status = proc_get_status($phpProcess);
                $bsStatus = proc_get_status($browserSyncProcess);

                if (!$status['running'] || !$bsStatus['running']) {
                    // proc_terminate($phpProcess);
                    proc_terminate($browserSyncProcess);
                    break;
                }

                sleep(1);
            }

            proc_close($phpProcess);
            proc_close($browserSyncProcess);
        } else {
            echo "Failed to start the development server.\n";
        }
    }

    private function showHelp() {
        echo "Usage: cli.php [command]\n";
        echo "\n";
        echo "Commands:\n";
        echo "  make:template [name]  Create a new template\n";
        echo "  make:page [name]      Create a new page\n";
        echo "  serve                 Start the development server\n";
    }
}

$cli = new CLI();
$cli->run();