<?php

class Reve {
    private int $id_reve;
    private string $libelle_reve;
    private DateTime $date_creation_reve;
    private int $id_famille_reve;
    private int $id_utilisateur;
    private int $id_type_reve;
    private string $titre_reve;
    private string $libelle_type_reve;
    

    
    public function __construct(int $id_reve, string $libelle_reve, DateTime $date_creation_reve, int $id_famille_reve, int $id_utilisateur, 
    int $id_type_reve, string $titre_reve, string $libelle_type_reve) {
        $this->id_reve = $id_reve;
        $this->libelle_reve = $libelle_reve;
        $this->date_creation_reve = $date_creation_reve;
        $this->id_famille_reve = $id_famille_reve;
        $this->id_utilisateur = $id_utilisateur;
        $this->id_type_reve = $id_type_reve;
        $this->titre_reve = $titre_reve;
        $this->libelle_type_reve = $libelle_type_reve;
      


    }

    
    public function getIdReve(): int
    { 
        return $this->id_reve;
    }

    public function getIdTypeReve(): int 
    { 
        return $this->id_type_reve;
    }
    
    public function getLibelleReve(): string 
    { 
        return $this->libelle_reve;
    }

    public function getTitreReve():string
    { 
        return $this->titre_reve;
    }
    
    public function getLibelleTypeReve():string
    { 
        return $this->libelle_type_reve;
    }
    
    
    public function getDateCreationReve(): DateTime 
    {  
        return $this->date_creation_reve;
    }
    
    public function getIdFamilleReve(): int
    { 
        return $this->id_famille_reve;
    }
    
    public function getIdUtilisateur(): int
    {
        return $this->id_utilisateur;
    }
    
    public function setIdReve(int $id_reve): void
    { 
        $this->id_reve = $id_reve;
    }



    public function setIdTypeReve(int $id_type_reve): void 
    {
        $this->id_type_reve = $id_type_reve;
    }
    
    public function setLibelleTypeReve(string $libelle_type_reve): void
    { 
       $this->libelle_type_reve = $libelle_type_reve;
    }

    public function setLibelleReve(string $libelle_reve): void 
    {
        $this->libelle_reve = $libelle_reve;
    }

    public function setTitreReve(string $titre_reve): void 
    {
         $this->titre_reve = $titre_reve;
    }
    
    public function setDateCreationReve(DateTime $date_creation_reve): void 
    {
        $this->date_creation_reve = $date_creation_reve;
    }
    
    public function setIdFamilleReve(int $id_famille_reve): void 
    {
        $this->id_famille_reve = $id_famille_reve;
    }
    
    public function setIdUtilisateur(int $id_utilisateur): void 
    {
        $this->id_utilisateur = $id_utilisateur;
    }
}

?>
