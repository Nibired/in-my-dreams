<?php

class Question 

{
  private int $id_question;
  private string $libelle_question;
  private int $id_qcm;
  private array $choix = [];

  public function __construct(int $id_question, string $libelle_question, int $id_qcm) 
  {
    $this->id_question = $id_question;
    $this->libelle_question = $libelle_question;
    $this->id_qcm = $id_qcm;
  }

  public function getIdQuestion(): int 
  {
    return $this->id_question;
  }

  public function setIdQuestion(int $id_question): void 
  {
    $this->id_question = $id_question;
  }

  public function getLibelleQuestion(): string 
  {
    return $this->libelle_question;
  }

  public function getIdQcm(): int 
  {
    return $this->id_qcm;
  }

  public function addChoix(Choix $choix): void 
  {
    $this->choix[] = $choix;
  }

  public function getChoix(): array 
  {
    return $this->choix;
  }
}
?>