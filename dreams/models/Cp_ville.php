<?php
class Cp_ville
{
    private int $id_cp_ville;
    private string $libelle_cp_ville;
    private string $libelle_ville;
   

    public function __construct(int $id_cp_ville, string $libelle_cp_ville, string $libelle_ville)
    {
        $this->id_cp_ville = $id_cp_ville;
        $this->libelle_cp_ville = $libelle_cp_ville;
        $this->libelle_ville = $libelle_ville;
       
    }

    public function getIdCpVille(): int
    {
        return $this->id_cp_ville;
    }

    public function getIdCpVilleStatic(): int
    {
        return $this->id_cp_ville_static;
    }

    public function setIdCpVille(int $id_cp_ville): void
    {
        $this->id_cp_ville = $id_cp_ville;
    }

    public function getLibelleCpVille(): string
    {
        return $this->libelle_cp_ville;
    }

    public function setLibelleCpVille(string $libelle_cp_ville): void
    {
        $this->libelle_cp_ville = $libelle_cp_ville;
    }

    public function getLibelleVille(): string
    {
        return $this->libelle_ville;
    }

    public function setLibelleVille(string $libelle_ville): void
    {
        $this->libelle_ville = $libelle_ville;
    }
}
?>