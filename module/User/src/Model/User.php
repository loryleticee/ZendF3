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

  public function exChangeArray(array $data)
  {
    $this->id = !empty($data['id']) ? $data['id'] : null;
    $this->nom = !empty($data['nom']) ? $data['nom'] : null  ;
    $this->prenom = !empty($data['prenom']) ? $data['prenom'] : null;
  }

  public function getArrayCopy(){

    return [
      'id' => $this->id->id,
      'nom' => $this->nom->nom,
      'prenom'=> $this->prenom->prenom,
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
        
        $this->inputFilter = $inputFilter;

         return $this->inputFilter; 
     } 





}
?>