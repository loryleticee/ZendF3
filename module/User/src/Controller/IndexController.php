<?php

/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use User\Model\UserTable;
use User\Model\User;
use User\Form\UserForm;
use Zend\Form\View\Helper\FormRow;
use Zend\Db\Sql\Ddl\Column\Varchar;
use Zend\Validator\StringLength;
use Zend\Crypt\Password\Bcrypt;
// use Zend\Form\Element;
// use Zend\Captcha;

class IndexController extends AbstractActionController
{
    private $table;

    public function __construct(UserTable $table) {
         $this->table = $table; 
    } 

    public function indexAction()
    {
        return new ViewModel([
            'users' => $this->table->fetchAll(),
        ]);
    }

    public function editAction()
    {

        $id = (int) $this->params()->fromRoute('id', 0);
        if (0 === $id) {
            return $this->redirect()->toRoute('user', ['action' => 'add']);
        }
        $userData = $this->table->getUser($id);
        //$userData =  $userData->prenom; 
       
        // Retrieve the user with the specified id. Doing so raises
        // an exception if the user is not found, which should result
        // in redirecting to the landing page.
        try {
            $user = $this->table->getuser($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('user', ['action' => 'index']);
        }

        $form = new UserForm();
        $form->bind($user); 
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        $viewData = ['id' => $id, 'form' => $form,'userData' => $userData];
        
        if (! $request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter($user->getInputFilter());
        $form->setData($request->getPost());

        //var_dump($user->id);die;
        if (! $form->isValid()) {
            
            return $viewData;
        }
       // var_dump($user->id);die;

        // Fix lerreur de user->id = 0 : avant condition isValid $user->id is good, but after $user->id == 0
        if(0!== $id){
            $user->id=$id;
        }

        // $validatorNom = new StringLength();
        // $validatorNom
        // ->setOptions(
        //     [
        //         'min' => 6,
        //     ]
        // );
        // $validatorPrenom = new StringLength();
        // $validatorPrenom
        // ->setOptions(
        //     [
        //         'min' => 3,
        //     ]
        // );

        // $validatorNom->setMessage('Youre string is ', StringLength::TOO_SHORT);
        // $validatorPrenom->setMessage('Youre string is ', StringLength::TOO_SHORT);
          
        
        if($user->validation($user->nom,$user->prenom)){

           $this->table->saveUser($user);

        }
        // else{

        //     $validatorNom->getMessages();
        // }
        

        //$this->table->saveUser($user);

        // Redirect to user list
        return $this->redirect()->toRoute('user', ['action' => 'index']);
    }
    public function addAction()
    {

        $form = new UserForm() ; 

        // $form->add([
        //     'type' => 'Zend\Form\Element\Captcha',
        //     'name' => 'captcha',
        //     'options' => [
        //         'label' => 'Please verify you are human',
        //         'captcha' => new Captcha\Dumb(),
        //     ],
        // ]);
        $form->get('submit')->setValue('Ajouter');

        $request = $this->getRequest();
        if(!$request->isPost()){
            return ['form' => $form];
        }

        $user = new User();

        $form->setData($request->getPost());
        
        if(! $form->isValid()){
            return ['form' => $form];
        }
        // $bcrypt = new Bcrypt();
        // $securePass = 'the stored bcrypt value';
        // $password = 'the password to check';

        // if ($bcrypt->verify($password, $securePass)) {
        //     echo "The password is correct! \n";
        // } else {
        //     echo "The password is NOT correct.\n";
        // }
        $bcrypt = new Bcrypt();
        
        $user->exchangeArray($form->getData());

        $securePass = $bcrypt->create($user->password);
        
        $user->setPassword($securePass);
      
        if($user->validation($user->nom,$user->prenom)){

            $this->table->saveUser($user);
 
         }
        return $this->redirect()->toRoute('home' );
            
        
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('user');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->table->deleteUser($id);
            }

            // Redirect to list of users
            return $this->redirect()->toRoute('user');
        }

        return [
            'id'    => $id,
            'user' => $this->table->getUser($id),
        ];
    }
}
