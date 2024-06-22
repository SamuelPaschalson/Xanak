<?php

namespace Xanak\Console;

class Console
{
    protected $commands = [];

    public function register($command, $callback)
    {
        $this->commands[$command] = $callback;
    }

    public function handle($argv)
    {
        $command = $argv[1] ?? null;
        $arguments = array_slice($argv, 2);

        if (isset($this->commands[$command])) {
            call_user_func_array($this->commands[$command], $arguments);
        } else {
            echo "Command not found.\n";
        }
    }
}
