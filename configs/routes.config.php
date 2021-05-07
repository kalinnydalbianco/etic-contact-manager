<?php return [
    '/'                 => ['controller' => 'AuthController', 'action' => 'login'],
    '/logout'           => ['controller' => 'AuthController', 'action' => 'logout'],
    '/register'         => ['controller' => 'AuthController', 'action' => 'signUp'],
    
    '/contacts'         => ['controller' => 'ContactsController', 'action' => 'list'],
    '/contacts/add'     => ['controller' => 'ContactsController', 'action' => 'create'],
    '/contacts/detail'  => ['controller' => 'ContactsController', 'action' => 'detail'],
    '/contacts/update'  => ['controller' => 'ContactsController', 'action' => 'update'],
    '/contacts/remove'  => ['controller' => 'ContactsController', 'action' => 'remove'],
    '/contacts/export'  => ['controller' => 'ContactsController', 'action' => 'export'],
    '/contacts/send'    => ['controller' => 'ContactsController', 'action' => 'send'],
];