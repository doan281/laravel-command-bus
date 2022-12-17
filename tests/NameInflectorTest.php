<?php
declare(strict_types=1);

namespace Edupham\CommandBus\Tests;

use Edupham\CommandBus\Command;
use Edupham\CommandBus\Handler;
use Edupham\CommandBus\NameInflector;
use PHPUnit_Framework_TestCase;

class NameInflectorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var NameInflector
     */
    private $inflector;

    public function setUp()
    {
        $this->inflector = new NameInflector();
    }

    /**
     * @test
     */
    public function should_return_handler_class_name()
    {
        $this->assertEquals(
            RegisterUserHandler::class,
            $this->inflector->inflect(new RegisterUser())
        );
    }
}

class RegisterUser implements Command
{
}

class RegisterUserHandler implements  Handler
{
    public function handle(Command $command)
    {
    }
}
