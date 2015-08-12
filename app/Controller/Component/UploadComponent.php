<?php
/**
 * MailerComponent
 *
 * This component is used for handling automated emailing stuff
 *
 * @property EmailComponent $Email The dependency email component used for email stuff handling
 * @property EmailServiceComponent $EmailService The dependency email service component 
 * used for email through AWS stuff handling
 */

class UploadComponent extends Component{
    public $components = array();
    
    public $controller = null;
    
    public $permitted = array(
        'image/gif',
        'image/jpeg',
        'image/jpg',
        'image/pjpeg',
        'image/png'
    );
    public $systemPath = null;
    public $filename = null;

    public function initialize(Controller $controller) {
        parent::initialize($controller);
        $this->controller =& $controller;        
        $this->systemPath = WWW_ROOT . 'system' . DS;
    }

    /**
     * Startup component
     *
     * @param object $controller Instantiating controller
     * @access public
    */
    public function startup(Controller $controller) {
        parent::startup($controller);
    }

    /**
     * uploads files to the server
     * @param string    $folder     The folder to upload the files e.g. 'img/files'
     * @param array     $formdata   The array containing the form file
     * @param string	$params     additional params
     * @param string	$itemId     Id of the item (optional) will create a new sub folder           
     * @return:
     * 		will return an array with the success of each file upload
     */
    public function uploadFile($folder, $formdata, $params = array(), $itemId = null) {
        $result = array();
        try{
            // if itemId is set create an item folder
            if ($itemId) {
                $folder_url = $this->systemPath . $folder . DS . $itemId;
            }else{
                $folder_url = $this->systemPath . $folder;           
            }
            //create Dir if no exist
            if (!is_dir($folder_url)) {
                mkdir($folder_url);
                $result['newFolder'] = true;
            }

            //generate filename
            $this->_generateFilename($formdata['name'], $params);
            // check filetype is ok
            $this->_checkType($formdata['type'], $params);
            //check for errors
            $this->_checkErrors($formdata['error']);
            $full_url = $folder_url . DS . $this->filename;
            // if file type ok upload the file
            if (file_exists($full_url) && $this->filname != 'default.png') {
                @unlink($full_url);
                $result['overrite'] = true;
            }elseif(file_exists($full_url)){
                throw new Exception('Trying to delete default.png');
            }
            $success = move_uploaded_file($formdata['tmp_name'], $full_url);
            // if upload was successful
            if ($success) {
                // save the url of the file
                $result['error'] = false;
                $result['filename'] = $this->filename;
            } else {
                throw new Exception ("Error uploaded File. Please try again.");
            }            
        }catch(Exception $e){
            $result['error'] = $e->getMessage();            
        }
        return $result;
    }

    /**
     * Check File type for availability
     * @param string $type type of uploading file
     * @param string $permitted Allowed types if empty, will take Default values
     * @return bool True if type Permitted, else Throw new Exception
     */
    protected function _checkType($type, $params) {
        if (!isset($params['permitted']) || !$params['permitted']) {
            $params['permitted'] = $this->permitted;
        }
        if(in_array($type, $params['permitted'])){
            $return = true;
        }else{
            throw new Exception('File Not Permitted');
        }
        return $return;
    }

    /**
     * Check File Extension for availability
     * 
     * 
     * @param string $type type of uploading file
     * @return string File Extension string 
     *       Throw new exception if no extension found
     */
    protected function _findExtension($filename = ''){
        if(!$filename){
            throw new Exception('File havnt extension');
        }else{
            $tempArray = explode('.', $filename);
            $return = end($tempArray);
        }
        return $return;
    }

    /**
     * Generate Filename
     * 
     * Add filename to public $filename variable
     * 
     * @param string $name Uploading file name
     * @return exception Throw new exception if no fileName
     */
    protected function _generateFilename($filename = '' , $params = null){
        if(!$filename){
            throw new Exception('No name Specified');
        }
        $extension = $this->_findExtension($filename);
        if (isset($params['newFileName']) && $params['newFileName']) {
            $this->filename = $params['newFileName'] . '.' . $extension;
        } else {
            $this->filename = md5(microtime()) . '.' . $extension;
        }
    }

    /**
     * Check for upload errors
     * 
     * @param string $error Error response from server
     * @return bool False if no errors found else Throw Exception
     */
    protected function _checkErrors($error = '') {
        switch ($error) {
            case 0:
                $return = false;
                break;
            case 3:
                // an error occured
                $return = "Error uploading file. Please try again.";
                break;
            case 3:
                // an error occured
                $return = "Error uploading file. Please try again.";
                break;
            default:
                // an error occured
                $return = "System error uploading File. Contact webmaster.";
                break;
        }
        if($return){
            throw new Exception($error);
        }
        return $return;
    }
}
