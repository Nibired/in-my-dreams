<?php

class Mot_cle
{
    private int $id_mot_cle;
    private string $libelle_mot_cle;

    public function __construct(int $id_mot_cle, string $libelle_mot_cle)
    {
        $this->id_mot_cle = $id_mot_cle;
        $this->libelle_mot_cle = $libelle_mot_cle;
    }

    public function getIdMotCle(): int 
    {
        return $this->id_mot_cle;
    }

    public function setIdMotCle(int $id_mot_cle): void 
    {
        $this->id_mot_cle = $id_mot_cle;
    }

    public function getLibelleMotCle(): string 
    {
        return $this->libelle_mot_cle;
    }

    public function setLibelleMotCle(string $libelle_mot_cle): void 
    {
        $this->libelle_mot_cle = $libelle_mot_cle;
    }
}