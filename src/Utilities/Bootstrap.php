<?php
namespace App\Utilities;
/**
* class Bootstrap - representation of main MVC logic 
*
*/
class Bootstrap
{
    /**
    * Create instance of Web or Cli controller
    *
    * @return void
    */
    public function run()
    {
        //Set controller
        $controller = $this->getController();
        //Get action
        $action = $this->getAction();
        // Create instance of controller with param
        $this->isCreatedInstance($controller, $action);
    }

    /**
    * Restart game
    *
    * @return void
    */
    public function restart()
    {
        session_destroy();
    }

    /**
    *   Get controller
    *
    * @return string Controller name
    */
    protected function getController()
    {
        $controller = "Web";

        if(IsClient)
        {
            $controller = "Cli";
        }
        
        // Return controller name
        return $controller;
    }

    /*
    * Get action method
    *
    */
    protected function getAction()
    {
        //Set index as default method
        return 'index';
    }

    /**
    * Get routing
    */
    protected function getRout()
    {
        if (isset($_GET['url'])) {
            $params = array();
            $params = explode("/", $_GET['url']);
            $controller = ucwords($params[0]);
            
            if (isset($params[1]) && !empty($params[1])) {
                $action = ucwords($params[1]);
            }
            if (isset($params[2]) && !empty($params[2])) {
                $query = $params[2];
            } 
            
        }
    }

    /**
    * Check for controller innstance
    *
    * @param string $controller
    * @param string $action
    *
    * @return void
    */
    protected function isCreatedInstance($controller, $action)
    {
        //Call controller namespace
        $class = new \ReflectionClass('App\Controllers\\'. $controller);
        //Check for existing method
        if(!$class->hasMethod($action))
        {
            //Exit of app and print error message
            exit("Missing method: $action");
        }
        //Create new instance of Class
        $instance = $class->newInstance();

        call_user_func(array($instance, $action)); 


    }
   
}
