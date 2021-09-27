<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');  
  
require_once APPPATH."/third_party/classZebra.php";   
   
class PrintZebra extends classZebra {  
    public function __construct() {  
        parent::__construct();  
    }  
}  
?>