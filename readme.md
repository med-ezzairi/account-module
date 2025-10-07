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
];
```

2. Permission assignment

3. Permission verification

After Permission definition and assignment we could check the User's permission by calling the helper `allowed(permission_name)`. If user is allowed the code will continue execution, if not allowed an exception will be thrown

## Tests
Sorry, no tests are provided for now

## Contributing

Pull requests are welcome. For major changes, please open an issue first
to discuss what you would like to change.

## License

[MIT](https://choosealicense.com/licenses/mit/)