<?php
/**
 * Config-file for navigation bar.
 *
 */
return [

    // Use for styling the menu
    'class' => 'navbar',
 
    // Here comes the menu strcture
    'items' => [

        // This is a menu item
        'home'  => [
            'text'  => 'Home',
            'url'   => $this->di->get('url')->create(''),
            'title' => 'Home route of current frontcontroller'
        ],

        'questions'  => [
            'text'  => 'Questions',
            'url'   => $this->di->get('url')->create('questions'),
            'title' => 'Home route of current frontcontroller'
        ],


        'tags'  => [
            'text'  => 'Tags',
            'url'   => $this->di->get('url')->create('tags'),
            'title' => 'Home route of current frontcontroller'
        ],

        'users'  => [
            'text'  => 'Users',
            'url'   => $this->di->get('url')->create('users/active'),
            'title' => 'Home route of current frontcontroller'
        ],
 
        // This is a menu item
        'about' => [
            'text'  =>'About',
            'url'   => $this->di->get('url')->create('about'),
            'title' => 'Internal route within this frontcontroller'
        ],
    ],
 
    // Callback tracing the current selected menu item base on scriptname
    'callback' => function ($url) {
        if ($url == $this->di->get('request')->getRoute()) {
                return true;
        }
    },

    // Callback to create the urls
    'create_url' => function ($url) {
        return $this->di->get('url')->create($url);
    },
];
