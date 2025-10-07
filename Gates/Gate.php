<?php
namespace Modules\Account\Gates;


use Modules\Account\Contracts\Gate as GateContract;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Contracts\Container\Container;
//use Modules\Account\Exceptions\AuthorizationException; //TODO: fix this to be used
use Illuminate\Auth\Access\AuthorizationException;

class Gate implements GateContract
{
    use HandlesAuthorization;
    
    protected $container;
    protected $userResolver;
    
    public function __construct(Container $container, callable $userResolver)
    {
        $this->container    = $container;
        $this->userResolver = $userResolver;
    }
    
    
    public function check($resources, $arguments = [])
    {
        $user = $this->resolveUser();
        
        return collect($resources)->every(function ($resource) use ($user, $arguments) {
            return $this->raw($user, $resource, $arguments);
        });
    }
    
    public function authorize($resource, $arguments = [])
    {
        return $this->raw($this->resolveUser(), $resource, $arguments) ? $this->allow() : $this->deny();
    }
    
    protected function raw(User $user, $resource, $arguments = [])
    {
        $list = $user->getPermissions();
        $authorized = array_key_exists( $resource, $list ) && $list[$resource] === TRUE; 
        return $authorized === TRUE ? TRUE : $this->deny();
    }
    
    protected function resolveUser()
    {
        return call_user_func($this->userResolver);
    }
    
    protected function deny($message = 'This action is unauthorized.')
    {
        throw new AuthorizationException($message);
    }
}

