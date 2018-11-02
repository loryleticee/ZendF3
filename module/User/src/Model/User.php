<?php
namespace User\Model;

class User
{
    protected $id;
    protected $nom;
    protected $prenom;

  public function exChangeArray(array $data)
  {
    $this->id = $data['id'];
    $this->nom = ['nom'];
    $this->prenom = ['prenom'];
    $this->email = ['email'];
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

  public function getEmail()
  {
    return $this->email;
  }
}
?>