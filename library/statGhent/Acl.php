<?php
/**
 * @author Olivier Parent adapted by Stefaan Christiaens & Tom Van humbeek
 */
class statGhent_Acl extends Zend_Acl
{
    const ROLE_USER = 'ROLE_USER';
    const ROLE_ALL   =  null       ;
    const ROLE_GUEST = 'ROLE_GUEST';

    public function __construct()
    {
        $this->addRole(self::ROLE_GUEST                         )
             ->addRole(self::ROLE_USER , array(self::ROLE_GUEST))
             ->allow(  self::ROLE_GUEST                         )
             ->_addModuleDefault()
        ;
    }

    protected function _addModuleDefault()
    {
//        $r = array();
//        $r['index'] = self::getResource('index');
//        $r['error'] = self::getResource('error');
//
//        $p = array();
//        //$p['edit'    ] = self::getPrivilege('edit'    );
//        $p['index'   ] = self::getPrivilege('index');
//        $p['error'   ] = self::getPrivilege('error');
//        //$p['login'   ] = self::getPrivilege('login'   );
//        //$p['logout'  ] = self::getPrivilege('logout'  );
//        //$p['register'] = self::getPrivilege('register');
//
//        $this->addResources($r)
//             ->allow(self::ROLE_GUEST, $r['index'], array(
//                 $p['index'   ],
//                 $p['error'   ],
//                 //$p['register'],
//             ))
//             ->allow(self::ROLE_USER, $r['index'], array(
//                 $p['index'    ],
//             ))
//             ->deny( self::ROLE_GUEST, $r['index'], array(
//                 //$p['login'   ],
//                 //['register'],
//             ))
        $r = array();
        $r['error'] = self::getResource('error');
        $r['index'] = self::getResource('index');
        $r['account'] = self::getResource('account');
        $r['profile'] = self::getResource('profile');

        $this->addResources($r);
        //Zend_Debug::dump($this->_resources);exit();
         return $this->allow(self::ROLE_GUEST, $r['error'])
                    ->allow(self::ROLE_GUEST, $r['index'])
                    ->allow(self::ROLE_GUEST, $r['account'])
                    ->allow(self::ROLE_USER, $r['profile'])
                    ->deny(self::ROLE_GUEST, $r['profile'])
        ;
    }

    /**
     * @param array $resources
     * @return Ahs_Acl
     */
    public function addResources($resources = array()) {
        foreach ($resources as $resource) {
            $this->addResource($resource);
        }

        return $this;
    }

    /**
     * @param string $controller Controller name.
     * @param string $module Module name.
     * @return string Class name of Controller.
     */
    public static function getResource($controller = 'index', $module = 'default')
    {
        $class_name = ucfirst($controller) . 'Controller';

        if ($module != 'default') {
            $class_name = ucfirst($module) . "_{$class_name}";
        }

        return $class_name;
    }

    /**
     * @param string $action Action method name.
     * @return string Method name of Action method.
     */
    public static function getPrivilege($action = 'index')
    {
        $method_name = lcfirst($action) . 'Action';

        return $method_name;
    }
}