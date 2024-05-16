<?php
    class Test {

        public function __construct() {
            $this->main();
        }
       
        public function main() {
            $mat1 = new Materiel("1", "PC", "Acer", Etat::D, "");
            $mat2 = new Materiel("2", "clavier", "Logitech", Etat::D, "");

            $stock = new Stock();
            $stock->addMaterielToList($mat1);
            $stock->addMaterielToList($mat2);

            $stock->stockToString();

        }




        




    }
?>