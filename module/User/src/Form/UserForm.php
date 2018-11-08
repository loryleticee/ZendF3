<?php 
namespace User\Form ; 

use Zend\Form\Form;


class UserForm extends Form {

public function __construct($name = null) {

    parent::__construct('user');

    $this->add([
        'name' => 'id',
        'type' => 'hidden',
    ]);
    $this->add([
        'name' => 'prenom',
        'type' => 'text',
        'options' =>['label' => 'Prénom', ],
        'attributes' =>[
            'required'=> 'required'
        ]
    ]);
    $this->add([
        'name' => 'nom',
        'type' => 'text',
        'options' =>['label' => 'Nom', ],
        'attributes' =>[
            'required'=> 'required'
        ]
    ]);
    $this->add([
        'name' => 'submit',
        'type' => 'submit',
        'attributes' =>[
            'id'=> 'submitbutton'
        ]
    ]);


}

}


?>