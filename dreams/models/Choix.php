<?php

class Choix {

    private int $id_choix;
    private string $libelle_choix;


    public function __construct(int $id_choix, string $libelle_choix)
    {
        $this->id_choix = $id_choix;
        $this->libelle_choix = $libelle_choix;
    }

    public function getIdChoix(): int
    {
        return $this->id_choix;
    }

    public function setIdChoix(int $id_choix): void
    {
        $this->id_choix = $id_choix; 

    }

    public function getLibelleChoix(): string 
    {
        return $this->libelle_choix;
    }

    public function setLibelleChoix (string $libelle_choix): void 
    {
        $this->libelle_choix = $libelle_choix;
    }

}