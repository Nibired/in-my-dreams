<?php


class Connexions {
    private int $id_connexion;
    private int $id_utilisateur;
    private DateTime $date_connexion;
    private DateTime $date_deconnexion;
    private string $etat;
    private DateTime $last_action;

    public function __construct(
        int $id_connexion,
        int $id_utilisateur,
        DateTime $date_connexion,
        DateTime $date_deconnexion,
        string $etat,
        DateTime $last_action
    ) {
        $this->id_connexion = $id_connexion;
        $this->id_utilisateur = $id_utilisateur;
        $this->date_connexion = $date_connexion;
        $this->date_deconnexion = $date_deconnexion;
        $this->etat = $etat;
        $this->last_action = $last_action;
    }

    public function getIdConnexion(): int {
        return $this->id_connexion;
    }

    public function setIdConnexion(int $id_connexion): void {
        $this->id_connexion = $id_connexion;
    }

    public function getIdUtilisateur(): int {
        return $this->id_utilisateur;
    }

    public function setIdUtilisateur(int $id_utilisateur): void {
        $this->id_utilisateur = $id_utilisateur;
    }

    public function getDateConnexion(): DateTime {
        return $this->date_connexion;
    }

    public function getLastAction(): DateTime {
        return $this->last_action;
    }

    public function setDateConnexion(DateTime $date_connexion): void {
        $this->date_connexion = $date_connexion;
    }

    public function getDateDeconnexion(): DateTime {
        return $this->date_deconnexion;
    }

    public function setDateDeconnexion(DateTime $date_deconnexion): void {
        $this->date_deconnexion = $date_deconnexion;
    }

    public function getEtat(): string {
        return $this->etat;
    }

    public function setEtat(string $etat): void {
        $this->etat = $etat;
    }

    public function setLastAction(DateTime $last_action): void {
        $this->last_action = $last_action;
    }
}

?>