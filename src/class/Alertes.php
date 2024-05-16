<?php
/** Classe Alertes :
 *  - Contient la liste des alertes (sous-classe Alerte)
 *  - Contient un boolean qui avertit lorsqu'une nouvelle alerte 
 *  est déclenchée
 *
 * 
 */
class Alertes {
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

?>