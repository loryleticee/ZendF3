<?php


namespace User\Model;

use DomainException;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Filter\ToInt; 
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Validator\StringLength;
use Webmozart\Assert\Assert;

class User implements InputFilterAwareInterface
{   
    public $id;
    public $nom;
    public $prenom;
    public $email;
    public $password;

  public function exChangeArray(array $data)
  {
    $this->id = !empty($data['id']) ? $data['id'] : null;
    $this->nom = !empty($data['nom']) ? $data['nom'] : null  ;
    $this->prenom = !empty($data['prenom']) ? $data['prenom'] : null;
    $this->email = !empty($data['email']) ? $data['email'] : null;
    $this->password = !empty($data['password']) ? $data['password'] : null;
  }

  public function getArrayCopy(){

    return [
      'id' => $this->id->id,
      'nom' => $this->nom->nom,
      'prenom'=> $this->prenom->prenom,
      'email'=> $this->email->email,
      'password'=> $this->password->password,
    ];
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

  public function setPrenom($prenom)
  {
    $this->prenom = $prenom;
  }
  public function getEmail()
  {
    return $this->email;
  }

  public function setEmail($email)
  {
    $this->email = $email;
  }
  public function getPassword()
  {
    return $this->password;
  }

  public function setPassword($password)
  {
    $this->password = $password;
  }

  public function setInputFilter(InputFilterInterface $inputFilter) {
     throw new DomainException(sprintf( '%s does not allow injection of an alternate input filter', __CLASS__ )); 
    } 
    public function getInputFilter() {
       if ($this->inputFilter) {
          return $this->inputFilter; 
        } 
        $inputFilter = new InputFilter();
        $inputFilter->add([ 'name' => 'id',
          'required' => true,
           'filters' => [ ['name' => ToInt::class], ], 
        ]);
        $inputFilter->add([ 'name' => 'nom',
         'required' => true,
          'filters' => [ 
            ['name' => StripTags::class],
            ['name' => StringTrim::class],
          ],
           'validators' => [
              [ 'name' => StringLength::class,
                'options' => [ 
                  'encoding' => 'UTF-8',
                  'min' => 1,'max' => 100, 
                ], 
              ], 
            ], 
        ]); 
        $inputFilter->add([ 
          'name' => 'prenom',
          'required' => true, 
          'filters' => [ 
            ['name' => StripTags::class],
            ['name' => StringTrim::class],
          ],
          'validators' => [ 
            [ 'name' => StringLength::class,
              'options' => [
                 'encoding' => 'UTF-8',
                  'min' => 1,
                   'max' => 100,
              ],
            ],
          ], 
        ]);
        $inputFilter->add([ 
          'name' => 'email',
          'required' => true, 
          'filters' => [ 
            ['name' => StripTags::class],
            ['name' => StringTrim::class],
          ],
          'validators' => [ 
            [ 'name' => StringLength::class,
              'options' => [
                 'encoding' => 'UTF-8',
                  'min' => 1,
                   'max' => 100,
              ],
            ],
          ], 
        ]); 
        $inputFilter->add([ 
          'name' => 'password',
          'required' => true, 
          'filters' => [ 
            ['name' => StripTags::class],
            ['name' => StringTrim::class],
          ],
          'validators' => [ 
            [ 'name' => StringLength::class,
              'options' => [
                 'encoding' => 'UTF-8',
                  'min' => 1,
                   'max' => 100,
              ],
            ],
          ], 
        ]); 
        
        $this->inputFilter = $inputFilter;

         return $this->inputFilter; 
     }

     public function validation($nom,$prenom){

          $validatorNom = new StringLength(6);

          $validatorNom
          ->setOptions(
              [
                  'min' => 6,
              ]
          );

          $validatorPrenom = new StringLength(['min' => 3, 'max' => 12]);

          $validatorPrenom
          ->setOptions(
              [
                  'min' => 3,
                  'message' => "fhjkhg",
              ]
          );

         //$validatorNom->setMessages();

        $validatorPrenom->setMessages([
          StringLength::TOO_SHORT => 'The string is too short',
        ]);

          
          if($validatorNom->isValid($nom) && $validatorPrenom->isValid($prenom)){
           
              return [
                'nom' =>$nom,
                'prenom' =>$prenom,
              ];
          }
          else{
           
            //current($message)
            return false;
          }
      }





}
?>