<?php
//account_group
return [
    'item'          => ($item = 'مجموعة'),
    'theitem'       => ($theitem = 'المجموعة'),
    'theitems'       => ($theitems = 'المجموعات'),
    'global'        => array(
        'action_list'       => "قائمة $theitems",
        'action_create'     => "إضافة $item",
        'action_edit'       => "تحديث $theitem",
        'action_show'       => "معلومات $theitem",
        'action_saving'     => "حفظ المعلومات المتعلقة بـ$item",
        
        'tooltip_users'     => "مستعملو $theitem",
        'tooltip_show'      => "عرض معلومات $theitem",
        'tooltip_edit'      => "تحديث معلومات $theitem",
        'tooltip_delete'    => "حذف $theitem",
        'no_item_was_found' => "لم يتم العثور على أي $item",
        
        'group'  		    => $item,
        //'id'  				=> 'المعرف',
        'libelle'  			=> "إسم $theitem",
        'permissions'       => "الآذونات",
        'members'           => "الأعضاء",
        'members_count'     => "عدد الأعضاء",
        'users'             => "المستعملون",
        'users_count'       => "عدد المستعملين",
        'permissions_count' => "عدد الآذونات",
        
        'save_permissions'  => "حفظ الآذونات",
        
        
    ),
    
    'validation'    => array(
        'attributes'    => array(
            'id'  				=> "المعرف",
            'name'  			=> "إسم $theitem",
            'permissions'  		=> "الآذونات",
        ),
        'messages'    => array(
            'is_decision.required_if'       => '',
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

