<?php


class Reponse {
    private int $id_reponse;
    private int $id_choix;
    private int $id_question;
    private int $id_utilisateur;
    private int $id_qcm;
    private $date_reponse;
    private string $libelle_reponse;
   

    public function __construct(int $id_reponse, int $id_choix, int $id_question, int $id_utilisateur, int $id_qcm, $date_reponse, string $libelle_reponse) {
        $this->id_reponse = $id_reponse;
        $this->id_choix = $id_choix;
        $this->id_question = $id_question;
        $this->id_utilisateur = $id_utilisateur;
        $this->id_qcm = $id_qcm;
        $this->date_reponse = $date_reponse;
        $this->libelle_reponse = $libelle_reponse;

    }

    public function getIdReponse(): int {
        return $this->id_reponse;
    }

    public function setIdReponse(int $id_reponse): void {
        $this->id_reponse = $id_reponse;
    }

    public function getIdChoix(): int {
        return $this->id_choix;
    }

    public function setIdChoix(int $id_choix): void {
        $this->id_choix = $id_choix;
    }

    public function getIdQuestion(): int {
        return $this->id_question;
    }

    public function getLibelleReponse(): string {
        return $this->libelle_reponse;
    }

    public function setIdQuestion(int $id_question): void {
        $this->id_question = $id_question;
    }

    public function getIdUtilisateur(): int {
        return $this->id_utilisateur;
    }

    public function setIdUtilisateur(int $id_utilisateur): void {
        $this->id_utilisateur = $id_utilisateur;
    }

    public function getIdQcm(): int {
        return $this->id_qcm;
    }

    public function setIdQcm(int $id_qcm): void {
        $this->id_qcm = $id_qcm;
    }

    public function getDateReponse() {
        return $this->date_reponse;
    }

    public function setDateReponse($date_reponse): void {
        $this->date_reponse = $date_reponse;
    }

    public function setLibelleReponse(string $libelle_reponse): void {
        $this->libelle_reponse = $libelle_reponse;
    }
}
?>