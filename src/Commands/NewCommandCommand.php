<?php

declare(strict_types=1);

namespace Dikki\Clipro\Core\Commands;

use Dikki\Clipro\Core\Clipro;
use Dikki\Clipro\Core\Commands\Base;
use Dikki\Clipro\Core\Commands\CommandInterface;
use Nette\Utils\FileSystem;

class NewCommandCommand extends Base implements CommandInterface
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return "new:command";
    }

    /**
     * @param array<mixed> $args
     * @return void
     */
    public function execute(array $args): int
    {
        $commandName = $this->cli->input("Enter command name without 'Command' suffix : ")->prompt();
        $commandName = ucwords($commandName);
        FileSystem::write(
            rtrim(Clipro::getCommandDir(), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $commandName . "Command.php",
            <<<PHP
            <?php

            declare(strict_types=1);

            namespace App\Commands;

            use Dikki\Clipro\Core\Commands\Base;
            use Dikki\Clipro\Core\Commands\CommandInterface;

            class {$commandName}Command extends Base implements CommandInterface
            {
                /**
                 * @return string
                 */
                public function getName(): string
                {
                    return "sample";
                }

                /**
                 * @param array<mixed> \$args
                 * @return void
                 */
                public function execute(array \$args): int
                {
                    \$this->cli->green("This is a sample command...\\n");
                    return 0;
                }
            }
            PHP
        );
        $this->cli->green("$commandName command file generated successfully.");
        return 0;
    }
}
