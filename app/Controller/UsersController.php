<?php

class UsersController extends AppController{

    var $name = 'Users';
    public $uses = array(
        'User',
        'Tweet',
        'Follower'
    );
    public $components = array(
        'Auth',
        'Upload'
    );

    function beforeFilter(){
        parent::beforeFilter();
    }

    function checkUser(){
        $u_id = $this->Session->read('User.id');
        return $u_id;
    }

    public function __imageresize($imagePath, $thumb_path, $destinationWidth, $destinationHeight){
        // The file has to exist to be resized
        if(file_exists($imagePath)){
            // Gather some info about the image
            $imageInfo = getimagesize($imagePath);

            // Find the intial size of the image
            $sourceWidth = $imageInfo[0];
            $sourceHeight = $imageInfo[1];

            if($sourceWidth > $sourceHeight){
                $temp = $destinationWidth;
                $destinationWidth = $destinationHeight;
                $destinationHeight = $temp;
            }

            // Find the mime type of the image
            $mimeType = $imageInfo['mime'];

            // Create the destination for the new image
            $destination = imagecreatetruecolor($destinationWidth, $destinationHeight);

            // Now determine what kind of image it is and resize it appropriately
            if($mimeType == 'image/jpeg' || $mimeType == 'image/jpg' || $mimeType == 'image/pjpeg'){
                $source = imagecreatefromjpeg($imagePath);
                imagecopyresampled($destination, $source, 0, 0, 0, 0, $destinationWidth, $destinationHeight, $sourceWidth, $sourceHeight);
                imagejpeg($destination, $thumb_path);
            }else if($mimeType == 'image/gif'){
                $source = imagecreatefromgif($imagePath);
                imagecopyresampled($destination, $source, 0, 0, 0, 0, $destinationWidth, $destinationHeight, $sourceWidth, $sourceHeight);
                imagegif($destination, $thumb_path);
            }else if($mimeType == 'image/png' || $mimeType == 'image/x-png'){
                $source = imagecreatefrompng($imagePath);
                imagecopyresampled($destination, $source, 0, 0, 0, 0, $destinationWidth, $destinationHeight, $sourceWidth, $sourceHeight);
                imagepng($destination, $thumb_path);
            }else{
                $this->Session->setFlash(__('This image type is not supported.'), 'flash_error');
            }

            // Free up memory
            imagedestroy($source);
            imagedestroy($destination);
        }
    }

    public function register(){
        $this->layout = 'default';
        if($this->u_id){
            $this->redirect(array('controller' => 'users', 'action' => 'main'));
        }

        if(!empty($this->request->data)){

            $this->request->data['User']['birthdate'] = date('Y-m-d', strtotime($this->request->data['User']['birthdate']));
            $data = $this->request->data;

            $uploaded = $this->Upload->uploadFile('pics', $this->request->data['User']['image']);
            $data['User']['password'] = md5($data['User']['password'] . 'tweeter');
            $validate = $this->User->validateRegistration($this->data['User']);

            if($validate['status']){
                if(!$uploaded['error']){
                    $source_image = WWW_ROOT . 'system' . DS . 'pics' . DS . $uploaded['filename'];

                    $destination_thumb_path = WWW_ROOT . 'system' . DS . 'thumbs' . DS . $uploaded['filename'];

                    $data['User']['image'] = $uploaded['filename'];

                    $save = $this->User->save($data);
                    $this->User->save($data);
                    if($save){
                        $this->__imageresize($source_image, $destination_thumb_path, 80, 80);

                        $this->redirect(array('controller' => 'users', 'action' => 'main'));
                        $this->Session->setFlash('Successfully registered');
                    }else{
                        $this->Session->setFlash('Failed to sign up');
                    }
                }else{
                    $this->Session->setFlash('Please upload a photo');
                }
            }else{
                $this->Session->setFlash($validate['message']);
            }
        }
    }

    public function login(){
        $this->layout = 'default';
        if($this->u_id && isset($this->u_id)){
            $this->redirect(array('controller' => 'users', 'action' => 'home'));
        }

        if(!empty($this->data)){
            $user = $this->User->validateLogin($this->data['User']);
            if(!empty($user)){
//
                $this->Session->write('User.id', $user['User']['id']);
                $this->Session->setFlash('Successfully logged in');
                $this->redirect(array('controller' => 'users', 'action' => 'home'));
            }else{
                $this->Session->setFlash('Wrong email/username or password');
            }
        }
    }

    public function logout(){
        $userId = $this->Session->read('User.id');
        if(!$this->u_id){
            $this->redirect(array('controller' => 'users', 'action' => 'main'));
        }
        $this->Session->destroy();
        $this->redirect(array('controller' => 'users', 'action' => 'main'));
    }

    public function myProfile(){
        $this->layout = 'default';
        $userId = $this->checkUser();
        //var_dump($userId);die;
        if(!$this->u_id){
            $this->redirect(array('controller' => 'users', 'action' => 'home'));
        }
        $currentUser = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $userId
            )
                )
        );

        $userTweets = $this->Tweet->find('all', array(
            'conditions' => array(
                'Tweet.user_id' => $userId
            )
                )
        );
        $this->set('u_id', $userId);
        $this->set('currentUser', $currentUser);
        $this->set('userTweets', $userTweets);
    }

    public function viewProfile($username = null){
        $this->layout = 'default';
        $userId = $this->checkUser();

        $user = $this->User->find('first', array(
            'conditions' => array(
                'username' => $username
            )
                )
        );

        $userTweets = $this->Tweet->find('all', array(
            'conditions' => array(
                'Tweet.user_id' => $user['User']['id']
            )
                )
        );

        $follower = $this->Follower->find('first', array(
            'conditions' => array(
                'user_id' => $user['User']['id'],
                'follower_id' => $userId
            )
                ));

        $this->set('follower', $follower);
        $this->set('userTweets', $userTweets);
        $this->set('user', $user);
        $this->set('userId', $userId);
    }

    public function follow($id = null){
        //$this->layout = 'default';
        $userId = $this->checkUser();

        if(!$this->u_id){
            $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }

        $currentUser = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $userId
            ),
            'fields' => array('User.id')
                )
        );

        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $id
            )
                )
        );

        $data = array();
        $data['Follower']['user_id'] = $id;
        $data['Follower']['follower_id'] = $userId;
        $save = $this->Follower->save($data);
        if($save){
            $this->redirect(array('controller' => 'users', 'action' => 'viewProfile', $user['User']['username']));
        }
    }

    public function unfollow($id = null){
        if(!$this->u_id){
            $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }

        $userId = $this->checkUser();
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $id
            )
                )
        );
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $id
            )
                )
        );

        $follower = $this->Follower->find('first', array(
            'conditions' => array(
                'Follower.follower_id' => $userId,
                'Follower.user_id' => $user['User']['id']
            ),
            'fields' => array(
                'Follower.id'
            )
                ));

        if(!empty($follower)){
            $this->Follower->delete($follower['Follower']['id']);
            $this->redirect(array('controller' => 'users', 'action' => 'viewProfile', $user['User']['username']));
        }
    }

    public function followers(){

        $this->layout = 'default';
        $userId = $this->checkUser();

        $followers = $this->User->find('all', array(
            'conditions' => array(
                'Follower.user_id' => $userId
            ),
            'joins' => array(
                array(
                    'alias' => 'Follower',
                    'table' => 'followers',
                    'type' => 'left',
                    'conditions' => array(
                        'User.id = Follower.follower_id',
                    )
                )
            ),
            'fields' => array(
                'User.first_name',
                'User.last_name',
                'User.username',
                'User.image'
            )
                ));
        $this->set('followers', $followers);
    }

    public function following($id = null){
        $this->layout = 'default';
        $userId = $this->checkUser();

        $followings = $this->User->find('all', array(
            'conditions' => array(
                'Follower.follower_id' => $userId
            ),
            'joins' => array(
                array(
                    'alias' => 'Follower',
                    'table' => 'followers',
                    'type' => 'left',
                    'conditions' => array(
                        'User.id = Follower.user_id',
                    )
                )
            ),
            'fields' => array(
                'User.first_name',
                'User.last_name',
                'User.username',
                'User.image'
            )
                ));

        $this->set('followings', $followings);
    }

    public function main(){
        $this->layout = 'default';
        $u_id = $this->checkUser();
        $tweets = $this->Tweet->find('all', array(
            'order' => 'Tweet.id',
            'conditions' => array('Tweet.retweet_id' => NULL),
            'limit' => 6,
            'joins' => array(
                array(
                    'alias' => 'User',
                    'table' => 'users',
                    'type' => 'left',
                    'conditions' => array(
                        'Tweet.user_id = User.id'
                    )
                )
            ),
            'fields' => array(
                'Tweet.description',
                'User.username',
                'User.id',
                'Tweet.id'
            )
        )
        );

        $this->set('tweets', array_slice($tweets, 0, 5));
        $this->set('u_id', $u_id);
    }

    public function editProfile(){
        $this->layout = 'default';
        $u_id = $this->checkUser();

        if(!$u_id){
            $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }

        $user = $this->User->findById($u_id);
        $this->set('user', $user);

        if(!empty($this->request->data)){

            if($this->params['data']['cancel']){
                $this->redirect(array('controller' => 'users', 'action' => 'myProfile'));
            }

            $this->request->data['User']['birthdate'] = date('Y-m-d', strtotime($this->request->data['User']['birthdate']));
            $data = $this->request->data;


            if(!empty($data['User']['password'])){
                $data['User']['password'] = md5($data['User']['password'] . 'tweeter');
            }

            $save = $this->User->save(array(
                'id' => $data['User']['id'],
                'first_name' => $data['User']['first_name'],
                'last_name' => $data['User']['last_name'],
                'email' => $data['User']['email'],
                'birthdate' => $data['User']['birthdate'],
                'summary' => $data['User']['summary'],
                    ));

            if($save){
                $this->Session->setFlash('Successfully saved');
                $this->redirect(array('controller' => 'users', 'action' => 'myProfile'));
            }else{

                $this->Session->setFlash('Failed to save');
            }
        }
    }

    public function changePassword(){
        $u_id = $this->checkUser();

        if(!$u_id){
            $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }

        $user = $this->User->findById($u_id);

        $this->set('user', $user);

        if(!empty($this->request->data)){



            $data = $this->request->data;
            if(!empty($data['User']['password'])){
                $data['User']['password'] = md5($data['User']['password'] . 'tweeter');
            }
            $validate = $this->User->validateRegistration($this->data['User']);

            if(!empty($data['User']['password'])){

                if($validate['status']){

                    $this->User->save(array(
                        'id' => $data['User']['id'],
                        'first_name' => $user['User']['first_name'],
                        'last_name' => $user['User']['last_name'],
                        'email' => $user['User']['email'],
                        'birthdate' => $user['User']['birthdate'],
                        'summary' => $user['User']['summary'],
                        'password' => $data['User']['password']
                    ));
                    $this->redirect(array('controller' => 'users', 'action' => 'myProfile'));
                    $this->Session->setFlash('Your password was successfully changed');
                }else{
                    $this->Session->setFlash($validate['message']);
                }
            }else{
                $this->Session->setFlash('Please enter new password');
            }
        }
    }

    public function uploadPhoto(){
        $this->layout = 'default';
        $u_id = $this->checkUser();

        if(!$u_id){
            $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }
        $user = $this->User->findById($u_id);
        //var_dump($image);
        $this->set('user', $user);
        if(!empty($this->request->data)){
            $data = $this->request->data;
            $uploaded = $this->Upload->uploadFile('pics', $this->request->data['User']['image']);
            if(!$uploaded['error']){
                $source_image = WWW_ROOT . 'system' . DS . 'pics' . DS . $uploaded['filename'];
                $destination_thumb_path = WWW_ROOT . 'system' . DS . 'thumbs' . DS . $uploaded['filename'];

                $data['User']['image'] = $uploaded['filename'];
                $this->__imageresize($source_image, $destination_thumb_path, 80, 80);
                @unlink(WWW_ROOT . 'system' . DS . 'pics' . DS . $user['User']['image']);
                @unlink(WWW_ROOT . 'system' . DS . 'thumbs' . DS . $user['User']['image']);
                $this->User->save($data);
                $this->redirect(array('controller' => 'users', 'action' => 'myProfile'));
            }else{
                $this->Session->setFlash('Fail to upload');
            }
        }
    }

    public function home(){
        //$this->layout = 'default';
        $u_id = $this->checkUser();
        if(!$u_id){
            $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }
        $tweets = $this->Tweet->find('all', array(
            'order' => 'Tweet.id',
            'conditions' => array('Tweet.retweet_id' => NULL),
            'limit' => 5,
            'joins' => array(
                array(
                    'alias' => 'User',
                    'table' => 'users',
                    'type' => 'left',
                    'conditions' => array(
                        'Tweet.user_id = User.id'
                    )
                )
            ),
            'fields' => array(
                'Tweet.description',
                'User.username',
                'User.id',
                'Tweet.id',
                'Tweet.user_id',
                'Tweet.image'
            )
                )
        );
        //var_dump($tweets);die;
        $this->set('u_id', $u_id);
        $this->set('tweets', $tweets);
    }

    public function test(){
        
    }

}

?>
