<?php
//account_user
return [
    'item'          => ($item = 'مستعمل'),
    'theitem'       => ($theitem = 'المستعمل'),
    //'theitems'       => ($theitems = 'المستعملون'),
    
    'global'        => array(
        'action_list'       => "الإسنادات",
        
        'groups'  		    => "المجموعات",
        'permissions'       => "الآذونات",
        
        'email'  			=> "البريد الإلكتروني",
        'name'  			=> "إسم $theitem",
        'search'  			=> "بحث",
        
        
        'action_searching'  => "البحث عن $theitem",
        'no_item_was_found' => "لم يتم العثور على أي $item",
        'item_found'        => "لقد تم العثور على $theitem",
        
        /*
        'action_create'     => "إضافة $item",
        'action_edit'       => "تحديث $theitem",
        'action_show'       => "معلومات $theitem",
        'action_saving'     => "حفظ المعلومات المتعلقة بـ$item",
        
        'tooltip_users'     => "مستعملو $theitem",
        'tooltip_show'      => "عرض معلومات $theitem",
        'tooltip_edit'      => "تحديث معلومات $theitem",
        'tooltip_delete'    => "حذف $theitem",
        
        
        
        
        */
        'save_permissions'  => "حفظ الآذونات",
        'save_groups'       => "حفظ المجموعات",
        
    ),
    
    'validation'    => array(
        'attributes'    => array(
            'email'  			=> "البريد الإلكتروني",
            'userEmail'  		=> "البريد الإلكتروني",
            'name'  			=> "إسم $theitem",
            'permissions'  		=> "الآذونات",
            'groups'  		    => "المجموعات",
            
        ),
        'messages'    => array(
            'groups.*.exists'     => 'لقد أدخلتم مجموعة غير صحيحة، المرجوا التأكد أو تحديث الصفحة',
        ),
    ),
    
    'back'    => array(
        
        'item_not_specified'        => "لم يتم تحديد $theitem",
        'save_success'              => "لقد تم حفظ $theitem بنجاح",
        'update_success'            => "لقد تم تحديث $theitem بنجاح",
        'delete_success'            => "لقد تم حذف $theitem بنجاح",
        'delete_error'              => "لم يتم حذف $theitem ، المرجو إعادة المحاولة",
        'not_found'                 => "لم يتم العثور على $theitem",
        
    ),
];

