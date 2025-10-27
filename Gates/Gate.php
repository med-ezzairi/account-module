<?php
namespace Modules\Account\Gates;


use Modules\Account\Contracts\Gate as GateContract;
use App\User;
use Illuminate\Contracts\Container\Container;
use Modules\Account\Exceptions\AuthorizationException;

class Gate implements GateContract
{
    //use HandlesAuthorization;
    
    protected $container;
    protected $userResolver;
    
    public function __construct(Container $container, callable $userResolver)
    {
        $this->container    = $container;
        $this->userResolver = $userResolver;
    }
    
    
    public function check($permission, $resource = null)
    {
        $user = $this->resolveUser();
        return $this->raw($user, $permission, $resource);
    }
    
    public function authorize($permission, $resource = null)
    {
        return $this->raw($this->resolveUser(), $permission, $resource);
    }
    
    protected function raw(User $user, $permission, $resource = null)
    {
        $list = $user->getPermissions();
        $authorized = array_key_exists( $permission, $list ) && $list[$permission] === TRUE; 
        
        
        // check permission based on attributes 
        // (should be a ressource/entity/model using the trait Modules\Account\Traits\HasResourcePermission
        // and has the attribute $resourcePermission defined and set to a valide class)
        if( $authorized 
            && $resource 
            && is_object($resource)
            && method_exists($resource, 'getResourcePermission') ){
                $resourcePermission = $resource->getResourcePermission();
                $authorized = $resourcePermission->isAuthorized( $user, $permission, $resource);
        }
        
        
        return $authorized === TRUE ? TRUE : $this->deny( trans('account::global.operation_denied') );
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

