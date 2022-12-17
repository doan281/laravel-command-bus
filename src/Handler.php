<?php
declare(strict_types=1);

namespace Edupham\CommandBus;

interface Handler
{
    /**
     * Handle a Command object
     *
     * @param Command $command
     * @return mixed
     */
    public function handle(Command $command);
}
