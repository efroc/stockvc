<?php

enum Etat: string { 
    case disponible;
    case pret;
    case reparation;
}

class Liste {
    private array $liste = [];
    
    public function __construct(array $liste) {
        $this->liste = $liste;
    }
    
    public function getListe(): array {
        return $this->liste;
    }
    
    public function setListe(array $liste): Liste {
        $this->liste = $liste;
        return $this;
    }
    
    public function addMateriel(Materiel $materiel): Liste {
        array_push($this->liste, $materiel);
    }    
   
}

class Materiel {

    /**
     * ident -> reference unique d'identification
     * type -> clavier, écran, souris etc
     * marque -> acer, asus etc
     * état -> dispo, prêté, réparation etc 
     * note -> commentaire sur le produit
     */    
    private string $ident; 
    private string $type;
    private string $marque;
    private Etat $etat;
    private string $note;

    public function __construct(string $ident, string $type, string $marque, Etat $etat, string $note) {   
        $this->ident = $ident;
        $this->type = $type;
        $this->marque = $marque;
        $this->etat = $etat;
        $this->note = $note;
    } 
    
    public function getIdent(): string {
        return $this->ident;
    }
    
    public function getType(): string {
        return $this->type;
    }
    
    public function getMarque(): string {
        return $this->marque;
    }
    
    public function getEtat(): Etat {
        return $this->etat;
    }
    
    public function getNote(): string {
        return $this->note;
    }

   
    
    
    

}
?>