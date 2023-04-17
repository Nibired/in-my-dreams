<?
class Note {
    private int $id_note;
    private int $note;
    private int $id_utilisateur;
    private int $id_reve;

    public function __construct(int $id_note, int $note, int $id_utilisateur, int $id_reve) {
        $this->id_note = $id_note;
        $this->note = $note;
        $this->id_utilisateur = $id_utilisateur;
        $this->id_reve = $id_reve;
    }

    public function getIdNote(): int {
        return $this->id_note;
    }

    public function getNote(): int {
        return $this->note;
    }

    public function getIdUtilisateur(): int {
        return $this->id_utilisateur;
    }

    public function getIdReve(): int {
        return $this->id_reve;
    }

    public function setIdNote(int $id_note): void {
        $this->id_note = $id_note;
    }

    public function setNote(int $note): void {
        $this->note = $note;
      }

    public function setIdUtilisateur(int $id_utilisateur): void {
        $this->id_utilisateur = $id_utilisateur;
    }

    public function setIdReve(int $id_reve): void {
        $this->id_reve = $id_reve;
    }
}
?>