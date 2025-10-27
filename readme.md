# Account Module 

This module lets you manage Groups of users, setup groups permissions and per user permissions, the reason behind this module is that you are free to define permissions in your config file as text and assign them to groups or users as you need. The final result is that you could check the user permission based on text (permission) you defined not ids (auto increment) used by other packages/modules.

## Installation

This module requires using the package `nwidart/laravel-modules` see the page [nwidart/laravel-modules](https://github.com/nWidart/laravel-modules).

```bash
composer require med-ezzairi/module-account
```

## Config and Migration

Check the config file under `Modules/Account/Config/account.php` to setup tables names.

Update the Model/Entity User in general under `app/Models/User`

```bash
php artisan module:migrate account
```

Update the Model User to use the trait `Modules\Account\Traits\UserUsingGroupsAndPermissions;`

as follow:
```
<?php

namespace App\Models;

...
use Modules\Account\Traits\UserUsingGroupsAndPermissions;

class User extends Authenticatable
{
    use HasFactory, Notifiable, UserUsingGroupsAndPermissions;
	
    public $table       = 'users';


```


## Usage

1. Permission definition

Check the file `Modules/Account/Config/permissions.php` to see the permissions definition.
The definition follows the:

```
<?php 

return [
    
    'module.entity'   => [
        'action1'     	=> "A description of the permission",
        'action2'  	    => "Second description of the permission",
        //Examples
        'index'     	=> "List users",
        'create'  	    => "Create new users",
        'activate' 		=> "Activate users account",
        'disable'     	=> "Disable users account",
    ],
    'shop.orders'        => [
        'create'            => "Create an order",
        'edit'              => trans("shop.order_permission_edit"), // to use the translation
        'view'              => "View an order",
        'delete'            => "Delete an order",
    ],
];
```

2. Permission assignment

Check the url: http://yourapplication/account (like: [http://localhost/account](http://localhost/account))

3. Permission verification

After Permission definition and assignment we could check the User's permission by calling the helper `allowed(permission_name)`, like this `allowed('shop.orders.delete');` from any where in your code (controller, service or repository). If the connected user is allowed the code will continue execution, if not allowed an exception will be thrown (check the `Modules\Account\Exceptions\AuthorizationException`)

4. Per Resource Permission

We have a logic to handle per-resource-permissions for specific Resources/Models/Entities. To use the ResourcePermission, add the trait `Modules\Account\Traits\HasResourcePermission` to the resource/model/entity and specify the `protected $resourcePermission` attribute.

```
use Modules\Account\Traits\HasResourcePermission;
use App\Permissions\Shop\OrderResourcePermission;

class Order extends Model
{
    
    use HasResourcePermission; // add the trait that define the logic
    
    protected $table        = 'shop_orders';
    protected $primaryKey   = 'id';
    protected $guarded      = ['id'];
    
    # define and set the attribute: give the class that define how to handle each action
    protected $resourcePermission = OrderResourcePermission::class;
	
	
```

In the `OrderResourcePermission` we need to create a method that will handle the permission logic, the method name must be same permission action, example `shop.orders.delete` (the action here is: `delete`)

```
<?php 

namespace App\Permissions\Shop;

use Modules\Account\Permissions\ResourcePermission;
use App\Models\Shop\Order;
use App\User;

class OrderResourcePermission extends ResourcePermission {
    
    /**
     * Check the user permission on the resource
     * 
     * @param User $user
     * @param Order $resource
     * @return boolean
     */
    protected function delete( User $user, Order $resource ) 
    {
        $role_id = $user->getRole();
        
        return $user->id == $resource->id || $role_id == 'admin';
    }
}

```

To check if the connect user is able/permitted to perform the requested action/permission on a resource, use the same helper, like this `allowed('shop.orders.delete', $order);`. Here we passed the resource as the second parameter.

#### Note: Be careful with per-resource-permission, the user should already has the permission to perform the action (direct permission assignment or assigned via group) and after checking the permission we will check if he is permitted for that action on that resource.

## Tests
Sorry, no tests are provided for now.

## Specific Help or Custom Integration

Please let me know about your need and I will help you.

## Contributing

Pull requests are welcome. For major changes, please open an issue first
to discuss what you would like to change.

## License

[MIT](https://choosealicense.com/licenses/mit/)