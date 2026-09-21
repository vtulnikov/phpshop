<?php

use vvt\Router;

//по умолчанию всем контроллерам добавляется action - index. При желании его можно переопределить ['controller' => 'Product', 'action' => 'view]
Router::add('^admin/(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$', ['admin_prefix' => 'admin']);
Router::add('^admin/?$', ['controller' => "Main", 'admin_prefix' => 'admin']);

Router::add('^(?:(?P<lang>[a-z]+)/)?product/(?P<slug>[a-z0-9-]+)/?$', ['controller' => 'Product']); 
Router::add('^(?:(?P<lang>[a-z]+)/)?category/(?P<slug>[a-z0-9-]+)/?$', ['controller' => 'Category']); 
Router::add('^(?:(?P<lang>[a-z]+)/)?page/(?P<slug>[a-z0-9-]+)/?$', ['controller' => 'Page']); 
Router::add('^(?:(?P<lang>[a-z]+)/)?search/?$', ['controller' => 'Search']); 
Router::add('^(?:(?P<lang>[a-z]+)/)?wishlist/?$', ['controller' => 'Wishlist']); 
Router::add('^(?P<controller>[a-z-]+)/(?P<action>[a-z-]+)/?$'); 
Router::add('^(?P<lang>[a-z]+)?/?$', ['controller' => "Main"]); //для главной страницы - ^$ - означает пустую строку
Router::add('^(?P<lang>[a-z]+)/?(?P<controller>[a-z-]+)/(?P<action>[a-z-]+)/?$'); 