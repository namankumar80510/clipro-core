<?php

declare(strict_types=1);

namespace Dikki\Clipro\Core\Commands;

interface CommandInterface
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param array<mixed> $args
     * @return void
     */
    public function execute(array $args): void;
}
