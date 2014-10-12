<?php
return array(
    'db' => array(
        'adapters' => array(
            'dbBase' => array(),
        ),
    ),
    'service_manager' => array(
            'invokables' => array(
                'Zend\Session\SessionManager' => 'Zend\Session\SessionManager',
            ),
        ),
    'view_manager' => array(
        'display_exceptions' => true,
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
);
