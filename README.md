# Command Bus 

> Simple Command Bus for Laravel framework

Based on [rosamarsky/laravel-command-bus](https://github.com/rosamarsky/laravel-command-bus)

## Installation
    composer require edupham/laravel-command-bus
    
If your Laravel version is less than 5.5, add the following line to the providers array in `config/app.php`:
```php
Edupham\CommandBus\CommandBusServiceProvider::class,
```

## Usage

#### Folder Structure
```
apps/Http/Controllers/
/User
--/Commands
----/RegisterUser.php
--/Controllers
----/AbsctractController.php
----/UserController.php
--/Handlers
----/RegisterUserHandler.php
``` 

#### Command

```php
namespace App\Http\Controllers\User\Commands;

class RegisterUser implements \Edupham\CommandBus\Command
{
    private $email;
    private $password;
    
    public function __construct(string $email, string $password)
    {
        $this->email = $email;
        $this->password = $password;
    }
    
    public function email(): string
    {
        return $this->email;
    }
    
    public function password(): string
    {
        return $this->password;
    }
}
```

#### Handler

```php
namespace App\Http\Controllers\User\Handlers;

class RegisterUserHandler implements \Edupham\CommandBus\Handler
{
    private $userRepository;
    
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    
    public function handle(\Edupham\CommandBus\Command $command): User
    {
        $user = new User(
            $command->email(),
            $command->password()
        );
        
        $this->userRepository->store($user);
        
        return $user;
    }
}
```

#### Controllers 

```php
namespace App\Http\Controllers\User\Controllers;

use Edupham\CommandBus\Command;
use Edupham\CommandBus\CommandBus;

class AbsctractController extends \Illuminate\Routing\Controller
{
    private $dispatcher;
    
    public function __construct(\Edupham\CommandBus\CommandBus $dispatcher) 
    {
        $this->dispatcher = $dispatcher;
    }
    
    public function dispatch(\Edupham\CommandBus\Command $command)
    {
        return $this->dispatcher->execute($command);
    }
}
```

```php
namespace App\Http\Controllers\User\Controllers;

use App\Http\Controllers\User\Commands\RegisterUser;
use Illuminate\Http\Request;

class UserController extends AbstractController
{
    public function store(Request $request)
    {
        $user = $this->dispatch(new RegisterUser(
            $request->input('email'),
            $request->input('password')
        ));
    
        return $user;
    }
}
```
