<?php

class Sexe
{
    private int $id_sexe;
    private string $libelle_sexe;
    

    public function __construct(int $id_sexe, string $libelle_sexe)
    {
        $this->id_sexe = $id_sexe;
        $this->libelle_sexe = $libelle_sexe;
        
    }


   public function getIdSexe(): int {
        return $this->id_sexe;
    }

    public function getIdSexeStatic(): int {
        return $this->id_sexe_static;
    }


    public function getLibelleSexe() {
        return $this->libelle_sexe;
    }

    public function setIdSexe(int $id_sexe): void {
        $this->id_sexe = $id_sexe;
    }

    public function setLibelleSexe(string $libelle_sexe): void
    {
        $this->libelle_sexe = $libelle_sexe;
    }

}
?>