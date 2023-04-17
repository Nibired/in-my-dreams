<?php

class Type_reve
{
    private $id_type_reve;
    private $Libelle_Type_Reve;

    public function __construct($id_type_reve, $Libelle_Type_Reve)
    {
        $this->id_type_reve = $id_type_reve;
        $this->Libelle_Type_Reve = $Libelle_Type_Reve;
    }

    public function getIdTypeReve()
    {
        return $this->id_type_reve;
    }

    public function setIdTypeReve($id_type_reve)
    {
        $this->id_type_reve = $id_type_reve;
    }

    public function getLibelleTypeReve()
    {
        return $this->Libelle_Type_Reve;
    }

    public function setLibelleTypeReve($Libelle_Type_Reve)
    {
        $this->Libelle_Type_Reve = $Libelle_Type_Reve;
    }
}