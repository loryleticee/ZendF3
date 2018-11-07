<?php
namespace User\Model;

class User
{
    public $id;
    public $nom;
    public $prenom;

  public function exChangeArray(array $data)
  {
    $this->id = $data['id'] ;
    $this->nom = $data['nom']  ;
    $this->prenom = $data['prenom'];
  }

  public function getId()
  {
    return $this->id;
  }

  public function getNom()
  {
    return $this->nom;
  }

  public function setNom($nom)
  {
    $this->nom = $nom;
  }

  public function getPrenom()
  {
    return $this->prenom;
  }

  public function sePreNom($prenom)
  {
    $this->prenom = $prenom;
  }
}
?>