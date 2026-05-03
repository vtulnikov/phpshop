<?php

use vvt\Router;

Router::add('^admin/(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$', ['admin_prefix' => 'admin']);
Router::add('^admin/?$', ['controller' => "Main", 'action' => 'index', 'admin_prefix' => 'admin']);

Router::add('^(?P<controller>[a-z-]+)/(?P<action>[a-z-]+)/?$'); 
Router::add('^$', ['controller' => "Main", 'action' => 'index']); //для главной страницы - ^$ - означает пустую строку