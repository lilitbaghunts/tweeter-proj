<?php

class User extends AppModel{

    var $name = 'User';

    public function validateRegistration($data){
        try{
            if($data['password']!=$data['confirm_password']){
                throw new Exception("Passwords don't match");
            }
            $return['status'] = true;
        }catch(Exception $e){
            $return['message'] = $e->getMessage();
            $return['status'] = false;
        }
        return $return;
    }

    public $validate = array(
        'username' => array(
            'rule' => 'isUnique',
            'message' => 'This username is already in use'
        )
    );

    function ValidateLogin($data){
        $conditions = array(
            'OR' => array(
                'username' => $data['username_or_email'],
                'email' => $data['username_or_email']
            ),
            'password' => md5($data['password'] . 'tweeter'),
        );
        $user = $this->find('first', array('conditions' => $conditions));
        if(!empty($user)){
            return $user;
        }else{
            return false;
        }
    }

}

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
