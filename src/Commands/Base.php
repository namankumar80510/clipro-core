<?php

declare(strict_types=1);

namespace Dikki\Clipro\Core\Commands;

use League\CLImate\CLImate;

abstract class Base implements CommandInterface
{
    protected CLImate $cli;

    public function __construct(CLImate $cli = null)
    {
        $this->cli = $cli ?? new CLImate();
    }

    abstract public function getName(): string;

    /**
     * Execute the command.
     *
     * @param array<string, mixed> $args
     * @return int
     */
    abstract public function execute(array $args): int;
}
