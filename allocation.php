<?php  
defined('_JEXEC') or die('Restricted access');  
$controller = JRequest::getWord('controller', 'allocation');  
$path = JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php'; 
  
if(file_exists($path)) { 
    
  require_once($path);  
  $classname = 'Controller'.$controller;  
  $controller = new $classname(); 
  $controller->execute($task);  
  $controller->redirect();  
} 
