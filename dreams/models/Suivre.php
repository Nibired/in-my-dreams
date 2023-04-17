<?php

class Suivre {
  private int $id_utilisateur;
  private int $id_utilisateur_suivre;

  public function __construct(int $id_utilisateur, int $id_utilisateur_suivre) {
    $this->id_utilisateur = $id_utilisateur;
    $this->id_utilisateur_suivre = $id_utilisateur_suivre;
  }

  public function setIdUtilisateur(int $id_utilisateur): void {
    $this->id_utilisateur = $id_utilisateur;
  }

  public function setIdUtilisateurSuivre(int $id_utilisateur_suivre): void {
    $this->id_utilisateur_suivre = $id_utilisateur_suivre;
  }

  public function getIdUtilisateur(): int {
    return $this->id_utilisateur;
  }

  public function getIdUtilisateurSuivre(): int {
    return $this->id_utilisateur_suivre;
  }
}

?>