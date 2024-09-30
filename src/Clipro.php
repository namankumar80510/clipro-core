<?php

declare(strict_types=1);

namespace Dikki\Clipro\Core;

use Dikki\Clipro\Core\Commands\CommandInterface;
use Dikki\Clipro\Core\Config\Config;
use Nette\Utils\Finder;

class Clipro
{
    private static string $configDir;
    private static string $commandDir;
    private array $commands = [];
    private Config $config;

    public function __construct(
        string $configDir,
        string $commandDir
    ) {
        self::$configDir = $configDir;
        self::$commandDir = $commandDir;

        if (!file_exists(self::getConfigDir())) die("Config dir does not exist.");
        if (!file_exists(self::getCommandDir())) die("Command dir does not exist.");

        # config
        $this->config = new Config(self::getConfigDir());

        # register commands
        $appCommandFiles = Finder::findFiles('*Command.php')->from($commandDir);
        $libraryCommandFiles = Finder::findFiles('*Command.php')->from(__DIR__ . '/Commands');

        foreach ($libraryCommandFiles as $file) {
            $command = "\\Dikki\\Clipro\\Core\\Commands\\" . $file->getBasename('.php');
            $this->register(new $command);
        }

        foreach ($appCommandFiles as $file) {
            $command = "\\App\\Commands\\" . $file->getBasename('.php');
            $this->register(new $command);
        }
    }

    public static function getConfigDir(): string
    {
        return self::$configDir;
    }

    public static function getCommandDir(): string
    {
        return self::$commandDir;
    }

    /**
     * Register a new command.
     *
     * @param CommandInterface $command
     * @return void
     */
    public function register(CommandInterface $command): void
    {
        $this->commands[$command->getName()] = $command;
    }

    /**
     * Run the application.
     *
     * @param $argv
     * @return void
     */
    public function run(mixed $argv): void
    {
        if (count($argv) < 2) {
            $this->showUsage();
            return;
        }
        // app commands
        $commandName = $argv[1];
        if (!isset($this->commands[$commandName])) {
            echo "Command not found. Available commands:\n";
            foreach ($this->commands as $command) {
                echo " - " . $command->getName() . "\n";
            }
            return;
        }

        $command = $this->commands[$commandName];
        $command->execute(array_slice($argv, 2));
    }

    /**
     * Show the usage of the application.
     *
     * @return void
     */
    private function showUsage(): void
    {
        // app welcome
        echo "\033[" . 34 . "m" . $this->config->get("app.name", "Clipro") . PHP_EOL . "\033[0m";
        echo "\033[" . 32 . "m" . $this->config->get("app.version" . "0.0.1") . PHP_EOL . "\033[0m";
        echo "Welcome to !" . PHP_EOL;
        echo "-------------------------------------" . PHP_EOL;
        echo PHP_EOL;

        // app commands usage
        echo "Usage: php app [command]\n";
        echo "Available commands:\n";
        foreach ($this->commands as $command) {
            echo " - " . $command->getName() . "\n";
        }
    }
}
