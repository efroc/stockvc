<?php

enum Etat: string { 
    case D; //dispo
    case P; // déjà prêté (ou pas dispo)
    case R; //reparation
}

class Stock {
    private array $liste;
    
    public function __construct() {
        $this->liste = [];
    }
   
    public function getListe(): array {
        return $this->liste;
    }
    
    public function setListe(array $liste) {
        $this->liste = $liste;
    }
    
    /** Ajoute un matériel à la liste de stock
     *  @param $materiel l'objet à rajouter
     *  @return bool faux et une erreur si l'ajout échoue, true sinon
     */
    public function addMaterieltoList(Materiel $materiel): bool {
        for($i = 0; $i < count($this->getListe()); $i++) {
            if($materiel = $this->getListe()[$i]) {
                print "Erreur: Matériel déjà dans la liste";
                return false;
            }    
        }
        array_push($this->liste, $materiel);
        return true;
    }    

    /** Supprime un matériel de la liste de stock
     *  @param $materiel l'objet à supprimer
     *  @return bool faux et une erreur si le retrait échoue, true sinon
     */
    public function suppMaterielFromList(Materiel $materiel): bool {
        for($i = 0; $i < count($this->getListe()); $i++) {
            if($materiel = $this->getListe()[$i]) {
                array_splice($this->liste, $i,1);
                return true;
            }    
        }
        print "Erreur: Tentative de suppression de matériel échouée";
        return false;    
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
    
    public function setType(string $type) {
        $this->type = $type;
    }
    
    public function setMarque(string $marque) {
        $this->marque = $marque;
    }

    public function setEtat(Etat $etat) {
        $this->etat = $etat;
    }
    
    public function setNote(string $note) {
        $this->note = $note;
    }    
    
    
    

}
?>