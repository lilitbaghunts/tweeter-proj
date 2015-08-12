<?php

class AuthComponent extends Component{

    var $components = array(
        'Session'
    );

    public function checkUser(){
        if(!$this->Session->check('User.id')){
            return NULL;
        }else{
            return (int) $this->Session->read('User.id');
        }
    }

}

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
