<?php

require_once('src/Liste.php');

class Test extends PHPUnit_Framework_TestCase {


   public function test() {
       $materiel1 = new Materiel("1", "souris", "logitech", "D", ""); 
       $materiel2 = new Materiel("2", "clavier", "hyperx", "P", ""); 
       $materiel3 = new Materiel("3", "tour", "acer", "R", ""); 
       $materiel4 = new Materiel("4", "clavier", "logitech", "D", "");  
       $liste = new Liste();
       $liste->addMaterieltoList($materiel1);
       $this->assertTrue($liste = [$materiel1]);
   }



}    
?>