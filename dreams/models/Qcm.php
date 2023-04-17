<?php 

require_once  'Question.php'; 
require_once 'Choix.php';
require_once 'Reponse.php';



class Qcm 

{

private int $id_qcm; 
private string $libelle_qcm; 
private array $questions = []; 


  public function __construct(int $id_qcm, string $libelle_qcm) 
  {
  
    $this->id_qcm = $id_qcm; 
    $this->libelle_qcm = $libelle_qcm; 
  }


  public function getIdQcm(): int 
  {
    return $this->id_qcm; 
  }

  public function setIdQcm(int $id_qcm): void 
  {
    $this->id_qcm = $id_qcm; 
  }

  public function getLibelleQcm(): string 
  {
    return $this->libelle_qcm; 
  }

  public function setLibelleQcm(string $libelle_qcm): void
   {
  
    $this->libelle_qcm = $libelle_qcm; 
  }

  public function addQuestion(Question $question): void 
  {
  
    $this->questions[] = $question; 
  }

  public function getQuestions(): array
  { 
    return $this->questions; 
  }


}



?> 