<?php

namespace vvt;

use Exception;

class View
{
    public string $content = "";
    public array $route;
    public string $layout;
    public string $view;
    public array $meta;

    public function __construct(array $route, $layout = "", $view = "", $meta = [])
    {
        $this->route = $route;
        $this->layout = $layout;
        $this->view = $view;
        $this->meta = $meta;
        
        if(false !== $this->layout){
            $this->layout = $this->layout ?: LAYOUT;
        }
    }
    public function render(array $data)
    {
        if(is_array($data)) extract($data);

        $prefix = str_replace("\\", "/", $this->route['admin_prefix']);
        $viewFile = APP . "/views/{$prefix}{$this->route['controller']}/{$this->view}.php";
        if(is_file($viewFile)){
            ob_start();
            require_once $viewFile;
            $this->content = ob_get_clean();
        } else{
            throw new Exception("Не найден вид " . $viewFile, 500);
        }
        if(false !== $this->layout){
            $layoutFile = APP . "/views/Layouts/{$this->layout}.php";
            if(is_file($layoutFile)){
                require_once $layoutFile;
            } else{
                throw new Exception("Не найден шаблон " . $layoutFile, 500);
            }
        }
    }
    public function getMeta()
    {
        $out = "<title>" . htmlspecialchars($this->meta['title'] ). "</title>" . PHP_EOL;
        $out .= '<meta name="description" content=" ' . htmlspecialchars( $this->meta['description'] ) . '" />' . PHP_EOL;
        $out .= '<meta name="keywords" content = " ' . htmlspecialchars( $this->meta['keywords'] ) . '" />' . PHP_EOL;
        return $out;
    }
}