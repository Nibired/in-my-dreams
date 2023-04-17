<?php


class Civilite
{
    private int $id_civilite;
    private string $libelle_civilite;

    public function __construct(int $id_civilite, string $libelle_civilite)
    {
        $this->id_civilite = $id_civilite;
        $this->libelle_civilite = $libelle_civilite;
    }

    public function getIdCivilite(): int
    {
        return $this->id_civilite;
    }

    public function setIdCivilite(int $id_civilite): void
    {
        $this->id_civilite = $id_civilite;
    }

    public function getLibelleCivilite(): string
    {
        return $this->libelle_civilite;
    }

    public function setLibelleCivilite(string $libelle_civilite): void
    {
        $this->libelle_civilite = $libelle_civilite;
    }
}