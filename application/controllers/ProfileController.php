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
        //Zend_Debug::dump($user);
        $view->assign('username',$user->getUsername());
        $view->assign('firstname',$user->getFirstname());
        $view->assign('surname',$user->getSurname());
        $view->assign('email',$user->getEmail());
        $view->assign('sex',$user->getSex());
        $view->assign('description',$user->getDescription());
        $view->assign('website',$user->getWebsite());
        
        $imgM = new Application_Model_ImageMapper();
        $img = new Application_Model_Image($imgM->read($user->getImage()));
        
        $view->assign('image',$img->getImage());
        $view->assign('mime',$img->getMimetype());
        $view->assign('path',APPLICATION_PATH);
    }

    public function editAction()
    {
        $form = new Application_Form_Register();
        $form->getElement("submit")->setLabel("Change");
        $form->getElement("passwordraw")->clearValidators()->setAllowEmpty(true)->setRequired(false);
        $form->getElement("passwordcheck")->clearValidators()->setAllowEmpty(true)->setRequired(false);
        $form->removeElement('username');
        
        
        $view = $this->view;
        $view->title = 'Edit Profile';
        
        $auth = Zend_Auth::getInstance();
        $id = $auth->getStorage()->read()['id'];
        if($id >0)
        {
            $userM = new Application_Model_UserMapper();
            $user = new Application_Model_User($userM->read($id));
           
            $users = array();
            $usrimg = $user->getImage();
            Zend_Debug::dump($usrimg);
            if (!empty($usrimg)) {
                $imgM = new Application_Model_ImageMapper();
                $img = new Application_Model_Image($imgM->read($user->getImage()));
                Zend_Debug::dump($img);
                $users['image'] = $img->getImage();
                
                $i = "http://localhost:8888/statghent/public/images/" . $img->getImage();
                $view->assign('image', $i);
            }
            
            
            $users['username'] = $user->getUsername();
            $users['firstname'] = $user->getFirstname();
            $users['surname'] = $user->getSurname();
            $users['sex'] = $user->getSex();
            $users['description'] = $user->getDescription();
            $users['website'] = $user->getWebsite();
            $users['email'] = $user->getEmail();
            
            //Zend_Debug::dump($users);
            $form->populate($users);
        }
        else {
            return $this->redirect('account/login/');
        }
        
        
        

        $request = $this->getRequest();

        if ($request->isPost() ) 
        {
        
            if ($form->isValid( $request->getPost() )) 
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
                    $user->setSex($val["sex"]);
                    $user->setDescription($val["description"]);
                    $user->setWebsite($val["website"]);
                    $modifiedd = new DateTime('now', new DateTimeZone('UTC'));
                    $modifiedd = $modifiedd->format('Y-m-d H:i:s');
                    $user->setModifieddate( $modifiedd );
                    
                    if($form->image->isUploaded())
                    {
                        $image = new Application_Model_Image();
                        $name = $form->image->getFileName(null,false);

                        $mime = $form->image->getMimeType();

                        $image->setMimetype($mime);
                        $image->setImage($name);
                        $exts = explode('/', $mime);
                        $ext = end($exts);

                        $new_image_name = $user->getUsername(). '.' . $ext;     

                        //NOT WORKING WHEN ONLY RENAME FILTER... NEITHER IS NOW
                        $form->image->addFilter('Rename',$new_image_name, true);


                        try {

                            if ($form->image->receive()) {
                                $imMapper = new Application_Model_ImageMapper();
                                $imid = $imMapper->save($image);

                                $user->setImage($imid);
                                $uMapper = new Application_Model_UserMapper();
                                $uid = $uMapper->save($user);
                                $user->setId($uid);

                                return $this->redirect('profile/index');
                            }
                            else {
                                throw new Zend_Exception("file not uploaded ");
                            }
                        
                        } catch (Zend_File_Transfer_Exception $e) {
                            throw new Zend_Exception("file not uploaded well");
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



