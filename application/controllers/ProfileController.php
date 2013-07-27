<?php

class ProfileController extends Zend_Controller_Action
{
    protected $_auth = null;
    public function init()
    {
        $this->_auth = Zend_Auth::getInstance();
    }

    public function indexAction()
    {
        $auth = Zend_Auth::getInstance();
        $id = $auth->getStorage()->read()['id'];
        $userM = new Application_Model_UserMapper();
        $user = new Application_Model_User($userM->read($id));
        $view = $this->view;
        
        $view->assign('username',$user->getUsername());
        $view->assign('firstname',$user->getFirstname());
        $view->assign('surname',$user->getSurname());
        $view->assign('email',$user->getEmail());
        $view->assign('gender',$user->getGender());
        $view->assign('description',$user->getDescription());
        $view->assign('website',$user->getWebsite());
        
        $view->assign('avatar',$user->getAvatar());
    }

    public function editAction()
    {
        $form = new Application_Form_Register();
        $form->getElement("submit")->setLabel("Change");
        $form->getElement("passwordraw")->clearValidators()->setAllowEmpty(true)->setRequired(false)->setOrder(17);
        $form->getElement("passwordcheck")->clearValidators()->setAllowEmpty(true)->setRequired(false)->setOrder(18);
        $form->removeElement('username');
        $form->removeElement('submit');
        $form->removeElement('passwordraw');
        $form->removeElement('passwordcheck');
        
        $password = new Zend_Form_Element_Password('passwordraw');
        $password
                    ->addFilter('StringTrim')
                    ->setAttrib('id','register-pwd')
                    ->setAttrib('placeholder','Change password')
                    ->setAttrib('tabindex', '2')
                    ->setAttrib('class', 'ui-input-password ui-shadow-inset ui-corner-all ui-btn-shadow ui-body-c')
                    ->setOrder(17);
        ;
        
        $passwordcheck = new Zend_Form_Element_Password('passwordcheck');
        $passwordcheck
                    ->addFilter('StringTrim')
                    ->addValidator('Identical', false, array('token' => 'passwordraw'))
                    ->setAttrib('id','register-pwdRpt')
                    ->setAttrib('placeholder','Repeat new password')
                    ->setAttrib('tabindex', '3')
                    ->setAttrib('class', 'ui-input-password ui-shadow-inset ui-corner-all ui-btn-shadow ui-body-c')
                    ->setOrder(18);
        ;
        
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Submit changes')
                ->setOptions(array('class' => 'btn btn-success'))
                ->setAttrib('id', 'register-btn')
                ->setAttrib('tabindex', '11')
                ->setOrder(20);
        ;
        $form->addElement($password);
        $form->addElement($passwordcheck);
        $form->addElement($submit);
        
        
        $view = $this->view;
        $view->title = 'Edit Profile';
        
        $auth = Zend_Auth::getInstance();
        $id = $auth->getStorage()->read()['id'];
        if($id >0)
        {
            $userM = new Application_Model_UserMapper();
            $user = new Application_Model_User($userM->read($id));
           
            $users = array();
            
            $img = $user->getAvatar();
            if (!empty($img)) 
            {
                $url = PUBLIC_PATH . "/images/" . $img;
                $url = join("/",explode("\\",$url));
                $url = explode("htdocs/", $url)[1];
                //Zend_Debug::dump($_SERVER);exit();
                $view->assign('image',"http://" . $_SERVER["HTTP_HOST"] . "/" . $url);
                $view->assign('hasimage', true);
            }
            else
                $view->assign('hasimage', false);
            
            
            $users['username'] = $user->getUsername();
            $users['firstname'] = $user->getFirstname();
            $users['surname'] = $user->getSurname();
            $users['gender'] = $user->getGender();
            $users['description'] = $user->getDescription();
            $users['website'] = $user->getWebsite();
            $users['email'] = $user->getEmail();
            
            $form->populate($users);
        }
        else {
            return $this->redirect('account/login/');
        }
        
        
        

        $request = $this->getRequest();

        if ($request->isPost() ) 
        {
            if ($form->isValid( $request->getPost())) 
            {
               $values = $form->getValues();
                $form->populate($values);
                $val = $this->getRequest()->getPost();
                if ($form->isValid( $request->getPost() )) {
                    Zend_debug::dump($val);
                    if(isset($val["passwordraw"]))
                    {
                        $user->setPasswordraw($val["passwordraw"]);
                    }
                    $user->setFirstname($val["firstname"]);
                    $user->setSurname($val["surname"]);
                    $user->setEmail($val["email"]);
                    $user->setGender($val["gender"]);
                    $user->setDescription($val["description"]);
                    $user->setWebsite($val["website"]);
                    $modifiedd = new DateTime('now', new DateTimeZone('UTC'));
                    $modifiedd = $modifiedd->format('Y-m-d H:i:s');
                    $user->setModifieddate( $modifiedd );
                    
                    if($form->avatar->isUploaded())
                    {
                        $mime = $form->avatar->getMimeType();
                        $exts = explode('/', $mime);
                        $ext = end($exts);
                        $new_img_name = base64_encode(statGhent_Utility::randomString(20) . microtime());
                        $form->avatar->addFilter('Rename',$new_img_name . '.' . $ext, true);
                        $user->setAvatar($new_img_name . '.' . $ext);

                        try {
                            if ($form->avatar->receive()) {
                                $uMapper = new Application_Model_UserMapper();
                                $uid = $uMapper->save($user);
                                $user->setId($uid);
                                return $this->redirect('profile/index');
                            }
                            else 
                            {
                                throw new Zend_Exception("Image wasn't received properly.");
                            }
                        
                        } 
                        catch (Zend_File_Transfer_Exception $e) 
                        {
                            throw new Zend_Exception("Something went wrong uploading the image.");
                        }
                    }
                    else {
                        $uMapper = new Application_Model_UserMapper();
                        $uid = $uMapper->save($user);
                        $user->setId($uid);
                        return $this->redirect('profile/index');
                    }
                }
            }
        }
        $view->form = $form;
    }
}



