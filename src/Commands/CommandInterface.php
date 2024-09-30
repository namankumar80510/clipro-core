<?php

declare(strict_types=1);

namespace Dikki\Clipro\Core\Commands;

interface CommandInterface
{
    /**
     * Get the command name.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Execute the command.
     *
     * @param array<string, mixed> $args
     * @return int
     */
    public function execute(array $args): int;
}
