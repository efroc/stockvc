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

    /** Affiche la liste de stock */
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
    private int $ident; 
    private string $type;
    private string $marque;
    private string $etat;
    private string $note;

    public function __construct(int $ident, string $type, string $marque, string $etat, string $note) {   
        if($etat !== "disponible" && $etat !== "en réparation" && $etat !== "déjà prêté") {
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

/********** TEST CLASSES DANS UN SEUL FICHIER **********/

/** Classe Alertes :
 *  - Contient la liste des alertes (sous-classe Alerte)
 *  - Contient un boolean qui avertit lorsqu'une nouvelle alerte 
 *  est déclenchée
 */
class ListAlerte {
    private array $alertes;
    private bool $nouvAlerte;

    public function __construct() {
        $this->alertes = [];
        $this->nouvAlerte = false;
    }

    public function getListe(): array {
        return $this->alertes;
    }

    public function setListe(array $alertes) {
        $this->alertes = $alertes;
    }    

    public function getNouvAlerte(): bool {
        return $this->nouvAlerte;
    }
    
    public function setNouvAlerte( bool $nouvAlerte) {
        $this->nouvAlerte = $nouvAlerte;
    }
    
    /** Ajoute une alerte à la liste et met nouvAlerte à true
     *  @param $alerte l'alerte à ajouter
     *  @return bool faux et une erreur si l'ajout échoue, true sinon
     */
    public function addAlertetoList(Alerte $alerte): bool {
        for($i = 0; $i < count($this->getListe()); $i++) {
            if($alerte = $this->getListe()[$i]) {
                print "Erreur: Alerte déjà dans la liste";
                return false;
            }    
        }
        array_push($this->alertes, $alerte);
        $this->setNouvAlerte(true);
        return true;
    }

    /** Supprime une alerte de la liste
     *  @param $alerte l'alerte à supprimer
     *  @return bool faux et une erreur si le retrait échoue, true sinon
     */
     public function suppAlerteFromList(Alerte $alerte): bool {
        for($i = 0; $i < count($this->getListe()); $i++) {
            if($alerte = $this->getListe()[$i]) {
                array_splice($this->alertes, $i,1);
                return true;
            }    
        }
        print "Erreur: Tentative de suppression de l'alerte échouée";
        return false; 
     }   
}

class Alerte {
    private String $id;
    private Pret $pret;
    private String $erreur;
    private String $date;

    public function __construct(String $id, Pret $pret, String $erreur) {
        $this->id = $id;
        $this->$pret = $pret;
        $this->erreur = $erreur;
        $this->date = date('l d m Y h:i:s');
    }    
}

/** Classes de Prets
 *  Constitue la liste des prêts effectués
 */
class ListPrets {
    private array $prets;

    public function __construct() {
        $this->prets = [];
    }    

    /** Getter/Setter pour $prets **/
    public function getListe(): array {
        return $this->prets;
    }
    
    public function setListe(array $prets) {
        $this->prets = $prets;
    }

    /** Ajoute un prêt dans la liste des prêts, et met le materiel en état de "PRET"
     *  @param $pret le prêt à ajouter
     *  @return bool faux et une erreur si l'ajout échoue, true sinon
     */
    public function addPretToList(Pret $pret): bool {
        for($i = 0; $i < count($this->prets); $i++) {
            if($pret = $this->prets[$i]) {
                print "Erreur: Prêt déjà dans la liste";
                return false;
            }
        }    
        array_push($this->prets, $pret);
        
        return true;
    }

    /** Retire un prêt de la liste des prêts, et met le materiel en état de "DISPO"
     *  @param $pret le prêt à retirer
     *  @return bool faux et une erreur si le retrait échoue, true sinon
     */
    public function suppPretFromList(Pret $pret): bool {
        for($i = 0; $i < count($this->getListe()); $i++) {
            if($pret = $this->getListe()[$i]) {
                array_splice($this->prets, $i,1);
               
                return true;
            }
        }
        print "Tentative de suppression du prêt échoué";
        return false;
    }

    /** Affiche tous les prêts **/
    public function pretsToString() {
        for($i = 0; $i < count($this->getListe()); $i++) {
            $this->getListe()[$i]->pretToString();
        }
        print nl2br("\n");
    }

    public function identAlreadyExists(int $ident): bool {
        for($i = 0; $i < count($this->getListe()); $i++) {
            if($this->getListe()[$i]->getIdent() === $ident) {
                return true;
            }
        }
        return false;
    }


}

class Pret {

    private int $ident;
    private String $start;
    private String $end;
    private String $demandeur;

    public function __construct(int $ident, String $start, String $end, String $demandeur) {
        $this->ident = $ident;
        $this->start = $start;
        $this->end = $end;
        $this->demandeur = $demandeur;
    }

    /** Getters/Setters **/
    public function getIdent(): int {
        return $this->ident;
    }
    
    public function getStart(): String {
        return $this->start;
    }
    
    public function getEnd(): String {
        return $this->end;
    }
    
    public function getDemandeur(): String {
        return $this->demandeur;
    }    

    public function setMateriel(Materiel $materiel) {
        $this->materiel = $materiel;
    }
    
    public function setStart(String $start) {
        $this->start = $start;
    }

    public function setEnd(String $end) {
        $this->end = $end;
    }

    public function setDemandeur(String $demandeur) {
        $this->demandeur = $demandeur;
    }

    /** Affiche un prêt **/
    public function pretToString() {
        print nl2br("Ident: ");
        print nl2br($this->getIdent());
        print nl2br("Début: " .$this->getStart(). 
        " | Fin: " .$this->getEnd(). " | Client: " .$this->getDemandeur());
        print nl2br("\n");
    }
}

?>