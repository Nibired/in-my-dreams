<?php

class Utilisateur 
{
    private int $id_utilisateur;
    private string $pseudo;
    private string $prenom;
    private DateTime $date_naissance;
    private string $email;
    private string $mdp;
    private ?string $descript;
    private Sexe $id_sexe;
    private Cp_ville $id_cp_ville;
    private Reve $id_famille_reve , $libelle_famille_reve;
    private Type_reve $id_type_reve, $libelle_type_reve;



    public function __construct(int $id_utilisateur, string $pseudo, string $prenom, DateTime $date_naissance, string $email, 
    string $mdp, Sexe $id_sexe, Cp_ville $id_cp_ville, ?string $descript = null)
    {
        $this->id_utilisateur = $id_utilisateur;
        $this->pseudo = $pseudo;
        $this->prenom = $prenom;
        $this->date_naissance = $date_naissance;
        $this->email = $email;
        $this->mdp = $mdp;
        $this->id_sexe = $id_sexe;
        $this->id_cp_ville = $id_cp_ville;
        $this->descript = $descript;
    }





    public function getIdUtilisateur(): int 
    {
        return $this->id_utilisateur;
    }

    public function setIdUtilisateur(int $id_utilisateur): void 
    {
        $this->id_utilisateur = $id_utilisateur;
    }




    public function getPseudo(): string 
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): void 
    {
        $this->pseudo = $pseudo;
    }




    public function getPrenom(): string 
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): void 
    {
        $this->prenom = $prenom;
    }



    public function getDateNaissance(): DateTime 
    {
        return $this->date_naissance;
    }

    public function setDateNaissance(DateTime $date_naissance): void 
    {
        $this->date_naissance = $date_naissance;
    }



    public function getEmail(): string 
    {
        return $this->email;
    }
    
    public function setEmail(string $email): void 
    {
        $this->email = $email;
    }



    public function getMdp(): string 
    {
        return $this->mdp;
    }

    public function setMdp(string $mdp): void 
    {
        $this->mdp = $mdp;
    }



    public function getDescript(): ?string 
    {
        return $this->descript;
    }

    public function setDescript(?string $descript): void 
    {
        $this->descript = $descript;
    }



    public function getSexe() : Sexe {
        return $this->id_sexe;
    }

    public function getIdSexe(): Sexe 
    {
        return $this->id_sexe;
    }

    public function setIdSexe(Sexe $id_sexe): void 
    {
        $this->id_sexe = $id_sexe;
    }




    public function getCpVille() : Cp_ville 
    {
        return $this->id_cp_ville;
    }

    public function getIdCpVille(): Cp_ville
    {
       return $this->id_cp_ville;
    }

    public function setIdCpVille(Cp_ville $id_cp_ville): void 
    {
        $this->id_cp_ville = $id_cp_ville;
    }





    public function getIdFamilleReve(): Reve
    {
        return $this->id_famille_reve;
    }

    public function setIdFamilleReve(Reve $id_famille_reve): void 
    {
        $this->id_famille_reve = $id_famille_reve;
    }

    public function getIdTypeReve(): Type_reve 
    {
        return $this->id_type_reve;
    }

    public function setIdTypeReve(Type_reve $id_type_reve): void  
    {
        $this->id_type_reve = $id_type_reve;
    }

    public function getLibelleTypeReve(): Type_reve   
    {
        return $this->libelle_type_reve;
    }

    public function setLibelleTypeReve(Type_reve $libelle_type_reve): void  
    {
        $this->libelle_type_reve = $libelle_type_reve;
    }

    public function getLibelleFamilleReve(): Famille_reve  
    {
        return $this->libelle_famille_reve;
    }

    public function setLibelleFamilleReve(Famille_reve $libelle_famille_reve): void  
    {
        $this->libelle_famille_reve = $libelle_famille_reve;
    }

   
}
  

