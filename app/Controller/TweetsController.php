<?php

class TweetsController extends AppController{

    var $name = 'Tweets';
    public $uses = array(
        'Tweet',
        'User',
        'Follower'
    );
    public $components = array(
        'Auth',
        'Upload',
        'Paginator');

    function beforeFilter(){
        parent::beforeFilter();
    }

    function checkUser(){
        $userId = $this->Session->read('User.id');

        return $userId;
    }

//    public $paginate = array(
//        'contain' => array('User', 'Tweet'),
//        'limit' => 10,
////        'order' => array(
////            'Ttweet.description' => 'asc'
////        )
//    );

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

    public function addTweet(){

        $userId = $this->Session->read('User.id');

        if(!$this->u_id){
            $this->redirect(array('controller' => 'users', 'action' => 'main'));
        }

        if(!empty($this->request->data)){
            $data = $this->request->data;
            $uploaded = $this->Upload->uploadFile('tweetPics', $this->request->data['Tweet']['image']);
            if(!$uploaded['error']){
                //$uploaded = $this->Upload->uploadFile('tweetPics', $this->request->data['Tweet']['image']);
                $source_image = WWW_ROOT . 'system' . DS . 'tweetPics' . DS . $uploaded['filename'];
                $destination_thumb_path = WWW_ROOT . 'system' . DS . 'thumbs' . DS . $uploaded['filename'];

                $data['Tweet']['image'] = $uploaded['filename'];
                $this->Tweet->save($data);

                $data['Tweet']['image'] = $uploaded['filename'];
                $this->__imageresize($source_image, $destination_thumb_path, 80, 80);
                $this->Tweet->save($data);
            }

            $this->Tweet->save(array(
                'user_id' => $this->u_id,
                'description' => $data['Tweet']['description']
            ));

            $this->Session->setFlash('Successfully added');
            $this->redirect(array('controller' => 'users', 'action' => 'myProfile'));
        }
    }

    public function loadMore(){
        $this->layout = false;
        $u_id = $this->checkUser();

        $this->paginate = array(
            'conditions' => array('Tweet.retweet_id' => null),
            'order' => array('Tweet.id ASC'),
            'offset' => 5,
            'joins' => array(
                array(
                    'alias' => 'User',
                    'table' => 'users',
                    'type' => 'left',
                    'conditions' => array(
                        'User.id = Tweet.user_id'
                    )
                )
            ),
            'fields' => array(
                'Tweet.*',
                'User.username'
            )
        );

        $tweets = $this->paginate();

        $this->set('u_id', $u_id);
        $this->set('tweets', $tweets);
    }

    public function retweet($id = null){
        if(!$this->u_id){
            $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }

        $retweet = $this->Tweet->find('first', array(
            'conditions' => array(
                'Tweet.id' => $id
            )
                ));

        $this->set('retweet', $retweet);

        if(!empty($this->request->data)){
            $data = $this->request->data;

            $this->Tweet->save(array(
                'user_id' => $this->u_id,
                'description' => $retweet['Tweet']['description'] . '<br>' . $data['Tweet']['retweet'],
                'retweet_id' => $id,
                'image' => $retweet['Tweet']['image']
            ));

            $this->Session->setFlash('Successfully added');
            $this->redirect(array('controller' => 'users', 'action' => 'myProfile'));
        }
    }

    public function myTweets(){
        $u_id = $this->checkUser();
        if(!$this->u_id){
            $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }
        $myTweets = $this->Tweet->find('all', array(
            'conditions' => array(
                'Tweet.user_id' => $u_id
            )
                ));

        $this->set('myTweets', $myTweets);
        //var_dump($myTweets);die;
    }

    public function followingTweets(){
        $this->layout = 'default';
        $u_id = $this->checkUser();
        if(!$this->u_id){
            $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }
        $followings = $this->Follower->find('all', array(
            'conditions' => array(
                'Follower.follower_id' => $u_id
            ),
            'joins' => array(
                array(
                    'alias' => 'User',
                    'table' => 'users',
                    'type' => 'left',
                    'conditions' => array(
                        'Follower.user_id = User.id'
                    )
                ),
                array(
                    'alias' => 'Tweet',
                    'table' => 'tweets',
                    'type' => 'left',
                    'conditions' => array(
                        'Tweet.user_id = User.id'
                    )
                ),
            ),
            'fields' => array(
                'Tweet.description',
                'Tweet.image',
                'Tweet.id',
                'User.username'
            )
                ));
        $this->set('followings', $followings);
    }

    public function allTweets(){

        $u_id = $this->checkUser();

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

}

?>
