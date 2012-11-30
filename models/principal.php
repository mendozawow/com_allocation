<?php  
defined('_JEXEC') or die('Restricted access');  
jimport('joomla.application.component.model');  
  
class ModelPrincipal extends JModel {  
  function getPrincipal() {  
    return "¿hola como va?";  
  }  
} 