<?php

declare(strict_types=1);

namespace Dikki\Clipro\Core\Commands;

use League\CLImate\CLImate;

abstract class Base implements CommandInterface
{
    protected CLImate $cli;

    public function __construct()
    {
        $this->cli = new CLImate();
    }

    abstract public function getName(): string;

    abstract public function execute(array $args): void;
}
