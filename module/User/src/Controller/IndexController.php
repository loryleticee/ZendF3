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
        $viewData = ['id' => $id, 'form' => $form];

        if (! $request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter($user->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return $viewData;
        }

        $this->table->saveuser($user);

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
        $user->exchangeArray($form->getData());
        $this->table->saveUser($user);
        return $this->redirect()->toRoute('home' );
            
        
    }

    public function deleteAction()
    {
        return new ViewModel([
            'users' => $this->table->fetchAll(),
        ]);
    }
}
