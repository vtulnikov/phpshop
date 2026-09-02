<?php

use vvt\Router;

Router::add('^admin/(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$', ['admin_prefix' => 'admin']);
Router::add('^admin/?$', ['controller' => "Main", 'action' => 'index', 'admin_prefix' => 'admin']);


Router::add('^(?:(?P<lang>[a-z]+)/)?product/(?P<slug>[a-z0-9-]+)/?$', ['controller' => 'Product', 'action' => 'view']); 
Router::add('^(?P<controller>[a-z-]+)/(?P<action>[a-z-]+)/?$'); 
Router::add('^(?P<lang>[a-z]+)?/?$', ['controller' => "Main", 'action' => 'index']); //для главной страницы - ^$ - означает пустую строку
Router::add('^(?P<lang>[a-z]+)/(?P<controller>[a-z-]+)/(?P<action>[a-z-]+)/?$'); 