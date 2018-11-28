<?php

class FileHandler
{
 
    private $con;
 
    public function __construct()
    {
        require_once dirname(__FILE__) . '/DbConnect.php';
 
        $db = new DbConnect();
        $this->con = $db->connect();
    }
 
 
    public function saveFile($file, $extension, $desc)
    {
        $name = round(microtime(true) * 1000) . '.' . $extension;
        $filedest = dirname(__FILE__) . UPLOAD_PATH . $name;
        move_uploaded_file($file, $filedest);
 
        $stmt = $this->con->prepare("INSERT INTO files (description, url) VALUES (?, ?)");
        $stmt->bind_param("ss", $desc, $name);
        if ($stmt->execute())
            return $name;
		
        return false;
    }
 
    public function getAllFiles()
    {
        $stmt = $this->con->prepare("SELECT id, description, url FROM files ORDER BY id DESC");
        $stmt->execute();
        $stmt->bind_result($id, $desc, $url);
 
        $files = array();
 
        while ($stmt->fetch()) {
 
            $temp = array();
            $absurl = 'http://' . gethostbyname(gethostname()) . '/FileUploadApi' . UPLOAD_PATH . $url;
            $temp['id'] = $id;
            $temp['desc'] = $desc;
            $temp['url'] = $absurl;
            array_push($files, $temp);
        }
 
        return $files;
    }
 
}