<?php

class Famille_reve
{
    private $id_famille_reve;
    private $Libelle_Famille_Reve;

    public function __construct($id_famille_reve, $Libelle_Famille_Reve)
    {
        $this->id_famille_reve = $id_famille_reve;
        $this->Libelle_Famille_Reve = $Libelle_Famille_Reve;
    }

    public function getIdFamilleReve()
    {
        return $this->id_famille_reve;
    }

    public function setIdFamilleReve($id_famille_reve)
    {
        $this->id_famille_reve = $id_famille_reve;
    }

    public function getLibelleFamilleReve()
    {
        return $this->Libelle_Famille_Reve;
    }

    public function setLibelleFamilleReve($Libelle_Famille_Reve)
    {
        $this->Libelle_Famille_Reve = $Libelle_Famille_Reve;
    }
}
?>