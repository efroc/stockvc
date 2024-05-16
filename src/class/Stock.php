<?php

class Stock {
    private array $liste;
    
    public function __construct() {
        $this->liste = [];
    }
   
    /** Getter/Setter pour $liste
     */
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
    public function addMaterielToList(Materiel $materiel): bool {
        for($i = 0; $i < count($this->getListe()); $i++) {
            if($this->getListe()[$i]->equalTo($materiel)) {
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
            if($this->getListe()[$i]->equalTo($materiel)) {
                array_splice($this->liste, $i,1);
                return true;
            }    
        }
        print "Erreur: Tentative de suppression de matériel échouée";
        return false;    
    }

    /** Affiche la liste de stock 
     */
    public function stockToString() {
        for($i = 0; $i < count($this->getListe()); $i++) { 
            $this->getListe()[$i]->materielToString();
        }
        print nl2br("\n");
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
    private string $etat;
    private string $note;

    public function __construct(string $ident, string $type, string $marque, string $etat, string $note) {   
        if($etat !== "D" && $etat !== "R" && $etat !== "P") {
            print "Erreur : Mauvais type pour état (D | P | R requis)";
        }
        else {
            $this->ident = $ident;
            $this->type = $type;
            $this->marque = $marque;
            $this->etat = $etat;
            $this->note = $note;
        }
    } 
    
    /** Getters/Setters attributs
     */
    public function getIdent(): string {
        return $this->ident;
    }
    
    public function getType(): string {
        return $this->type;
    }
    
    public function getMarque(): string {
        return $this->marque;
    }
    
    public function getEtat(): string {
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

    public function setEtat(string $etat) {
        $this->etat = $etat;
    }
    
    public function setNote(string $note) {
        $this->note = $note;
    }    
    
    /** Détermine si $this est égal à $mat2
     *  @param $mat2 l'objet comparé à $this
     *  @return bool true si égaux, false sinon
     */
    public function equalTo(Materiel $mat2): bool {
        if($this->getIdent() === $mat2->getIdent() && $this->getType() === $mat2->getType() && $this->getMarque() === $mat2->getMarque() && $this->getEtat() === $mat2->getEtat() && $this->getNote() === $mat2->getNote()) {
            return true;
        }
        else {
            return false;
        }
    }

    /** Affiche un objet Materiel
     */
    public function materielToString() {
        print "ID:  " .$this->getIdent(). " | Type: " .$this->getType(). " | Marque: " .$this->getMarque(). " | Etat: " .$this->getEtat(). " | Note: " .$this->getNote();
        print nl2br("\n");
    }
    
}
?>