<?php

return [
    'name'      => 'Account',
    'version'   => '0.1',
    
    //-- main application layout and section (see file: views.layouts.master.blade.php)
    'app_layout'    => env('MDL_ACCOUNT_APP_LAYOUT', 'layouts.admin'),
    'app_section'   => env('MDL_ACCOUNT_APP_SECTION', 'content'),
    
    
    //-- Tables names customization
    'table_names'    => array(
        
        'table_name_users'              => env('MDL_ACCOUNT_TABLE_NAME_USERS', 'users'),
        'table_name_groups'             => env('MDL_ACCOUNT_TABLE_NAME_GROUPS', 'acl_groups'),
        'table_name_group_user'         => env('MDL_ACCOUNT_TABLE_NAME_GROUP_USER', 'acl_group_user'),
        'table_name_user_permission'    => env('MDL_ACCOUNT_TABLE_NAME_USER_PERMISSION', 'acl_user_permission'),
        
    ),
    
];
