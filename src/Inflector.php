<?php
declare(strict_types=1);

namespace Edupham\CommandBus;

interface Inflector
{
    /**
     * Find a Handler for a Command
     *
     * @param Command $command
     * @return string
     */
    public function inflect(Command $command): string;
}
