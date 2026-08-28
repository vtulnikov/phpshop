<?php

namespace vvt;

use RedBeanPHP\R;

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
        extract($data);

        $prefix = str_replace("\\", "/", $this->route['admin_prefix']);
        $viewFile = APP . "/views/{$prefix}{$this->route['controller']}/{$this->view}.php";
        if(is_file($viewFile)){
            ob_start();
            require $viewFile;
            $this->content = ob_get_clean();
        } else{
            throw new \Exception("Не найден вид " . $viewFile, 500);
        }
        if(false !== $this->layout){
            $layoutFile = APP . "/views/Layouts/{$this->layout}.php";
            if(is_file($layoutFile)){
                require $layoutFile;
            } else{
                throw new \Exception("Не найден шаблон " . $layoutFile, 500);
            }
        }
    }
    public function getMeta()
    {
        $out = "<title>" . h($this->meta['title'] ) . "</title>" . PHP_EOL;
        $out .= '    <meta name="description" content=" ' . h( $this->meta['description'] ) . '" />' . PHP_EOL;
        $out .= '    <meta name="keywords" content = " ' . h( $this->meta['keywords'] ) . '" />' . PHP_EOL;
        return $out;
    }
    public function getDBLogs()
    {
        if(DEBUG){
            $logs = R::getDatabaseAdapter()
            ->getDatabase()
            ->getLogger(); //все работает, хз почему не видит этот метод
            return array_merge($logs->grep('SELECT'), $logs->grep('INSERT'), 
                               $logs->grep('UPDATE'), $logs->grep('DELETE'));
        }
    }
    public function getTemplatePart(string $file, ?array $data = null)
    {
        if(is_array($data)) extract($data);
        $file = APP . "/views/Template-parts/{$file}.php";
        if(is_file($file)) {
            require $file; //не через require once на случай, если понадобится несколько раз какой-то файл подключать
        } else{
            echo "Файл {$file} не найден";
        }

    }
}