<?php

class Controller{
    
    private $view;
    private $arrayView;
    private $clase;
    private $metodo;

    public function __construct(){
        $this->view = $_GET['url'];
        $this->arrayView = explode('/', $this->view);
        $this->clase = $this->arrayView[0];
        $this->metodo = $this->arrayView[1];
    }

    public function procesar(){
       $controller = $this->clase.'Controller.php';
       $file = 'controllers/'.$controller;
       $class = ucfirst($this->clase)."Controller";

       if(file_exists($file)){
          require_once $file;
        
          if(class_exists($class)){
            $instancia = new $class;

            if(method_exists($class, $this->metodo)){
               return true;
            }else{
                return false;
            }
          }else{
            return false;
          }
       }else{
           return false;
       }
    }

    public function include(){
        $controller = $this->clase.'Controller.php';
        $file = 'controllers/'.$controller;
        $class = ucfirst($this->clase)."Controller";

        require_once $file;
        $instancia = new $class;
        $method = $this->metodo;

        $instancia->$method();
    }
}