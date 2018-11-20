<?php 
namespace User\Form ; 

use Zend\Form\Form;


class ConnexionForm extends Form {

public function __construct($name = null) {

    parent::__construct('user');

    $this->add([
        'name' => 'email',
        'type' => 'email',
        'options' =>['label' => 'Email', ],
        'attributes' =>[
            'required'=> 'required'
        ]
    ]);
    $this->add([
        'name' => 'password',
        'type' => 'password',
        'options' =>['label' => 'Mot de passe', ],
        'attributes' =>[
            'required'=> 'required'
        ]
    ]);
    $this->add([
        'name' => 'submit',
        'type' => 'submit',
        'attributes' =>[
            'id'=> 'submitbutton',
            'value' => 'GO ! '
        ]
    ]);


}

}


?>