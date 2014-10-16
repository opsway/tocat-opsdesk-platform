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
    // @todo this should split provide by specific modules
    'navigation' => array(
        'top_nav' => array(
            'homepage' => array(
                'label' => 'Dashboard',
                'route' => 'home',
                'icon' => 'glyphicon glyphicon-home',
                'order' => 0,
            ),
            'teams' => array(
                'label' => 'Teams',
                'icon' => 'glyphicon glyphicon-flag',
                'route' => 'stub',
                'params' => array('id' => 'teams'),
                'resource' => 'top_nav:teams',
                'privilege' => 'list',
                'order' => 10,
            ),
            'staff' => array(
                'label' => 'Staff',
                'icon' => 'glyphicon glyphicon-user',
                'route' => 'stub',
                'params' => array('id' => 'staff'),
                'resource' => 'top_nav:staff',
                'privilege' => 'list',
                'order' => 20,
            ),
            'budget' => array(
                'label' => 'Budgets',
                'icon' => 'glyphicon glyphicon-usd',
                'route' => 'stub',
                'params' => array('id' => 'budget'),
                'resource' => 'top_nav:budget',
                'privilege' => 'list',
                'order' => 30,
                'pages' => array(
                    'ticket' => array(
                        'label' => 'Ticket',
                        'route' => 'stub',
                        'params' => array('id' => 'ticket'),
                    ),
                    'order' => array(
                        'label' => 'Order',
                        'route' => 'stub',
                        'params' => array('id' => 'order'),
                    ),
                ),
            ),
            'payment' => array(
                'label' => 'Payments',
                'icon' => 'glyphicon glyphicon-briefcase',
                'route' => 'stub',
                'params' => array('id' => 'payment'),
                'resource' => 'top_nav:payment',
                'privilege' => 'list',
                'order' => 40,
                'pages' => array(
                    'invoice' => array(
                        'label' => 'Invoices',
                        'route' => 'stub',
                        'params' => array('id' => 'invoices'),
                    ),
                    'transaction' => array(
                        'label' => 'Transactions',
                        'route' => 'stub',
                        'params' => array('id' => 'transactions'),
                    ),
                    'balance' => array(
                        'label' => 'Balances',
                        'route' => 'stub',
                        'params' => array('id' => 'balances'),
                    ),
                    'bonus' => array(
                        'label' => 'Bonuses',
                        'route' => 'stub',
                        'params' => array('id' => 'bonuses'),
                    ),
                ),
            ),
            'administration' => array(
                'label' => 'Administration',
                'icon' => 'glyphicon glyphicon-wrench',
                'route' => 'stub',
                'params' => array('id' => 'admin'),
                'resource' => 'top_nav:administration',
                'privilege' => 'list',
                'order' => 100,
            ),
        ),
    ),

);
