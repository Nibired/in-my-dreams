<?php

class Temoignages {
    private int $id_temoignage;
    private string $libelle_temoignage;
    private int $id_utilisateur;
    private DateTime $date_temoignage;
    private string $pseudo;

    public function __construct(int $id_temoignage, string $libelle_temoignage, int $id_utilisateur, string $date_temoignage, string $pseudo) {
        $this->id_temoignage = $id_temoignage;
        $this->libelle_temoignage = $libelle_temoignage;
        $this->id_utilisateur = $id_utilisateur;
        $this->date_temoignage = new DateTime($date_temoignage);
        $this->pseudo = $pseudo;
    }

    public function getIdTemoignage(): int {
        return $this->id_temoignage;
    }

    public function getLibelleTemoignage(): string {
        return $this->libelle_temoignage;
    }

    public function getIdUtilisateur(): int {
        return $this->id_utilisateur;
    }

    public function getDateTemoignage(): DateTime {
        return $this->date_temoignage;
    }

    public function getPseudo(): string {
        return $this->pseudo;
    }


    public function setIdTemoignage(int $id_temoignage): void {
        $this->id_temoignage = $id_temoignage;
    }

    public function setLibelleTemoignage(string $libelle_temoignage): void {
        $this->libelle_temoignage = $libelle_temoignage;
    }

    public function setIdUtilisateur(int $id_utilisateur): void {
        $this->id_utilisateur = $id_utilisateur;
    }

    public function setDateTemoignage(DateTime $date_temoignage): void {
        $this->date_temoignage = $date_temoignage;
    }

    public function setPseudo(string $pseudo): void {
        $this->pseudo = $pseudo;
    }
}



?>