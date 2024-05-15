<?php

class Prets {
    private array $prets;

    public function __construct() {
        $this->prets = [];
    }    

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
        for($i = 0; $i < count($this->getListe()); $i++) {
            if($pret = $pret->getListe()[$i]) {
                print "Erreur: Prêt déjà dans la liste";
                return false;
            }
        }    
        array_push($this->prets, $pret);
        $pret->getMateriel()->setEtat("P");
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
                $pret->getMateriel()->setEtat("D");
                return true;
            }
        }
        print "Tentative de suppression du prêt échoué";
        return false;
    }


}

class Pret {

    private Materiel $materiel;
    private String $start;
    private String $end;
    private String $demandeur;

    public function __construct(Materiel $materiel, String $start, String $end, String $demandeur) {
        $this->materiel = $materiel;
        $this->start = $start;
        $this->end = $end;
        $this->demandeur = $demandeur;
    }

    public function getMateriel(): Materiel {
        return $this->materiel;
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




}

?>