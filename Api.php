<?php

require_once dirname(__FILE__) . '/FileHandler.php';
require_once dirname(__FILE__) . '/Util.php';
 
$response = array();
 
if (isset($_GET['call'])) {
    switch ($_GET['call']) {
        case 'upload':
		
			$response['error'] = true;
            $response['message'] = 'Required parameters are not available';
 
            if (isset($_POST['desc']) && strlen($_POST['desc']) > 0 && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
                $util = new Util();
				$upload = new FileHandler();
 
                $file = $_FILES['file']['tmp_name'];
                $desc = $_POST['desc'];
				
				$file_name = $upload->saveFile($file, $util->getFileExtension($_FILES['file']['name']), $desc);
                if (!$file_name) {
					$response['error'] = true;
					$response['message'] = 'File uploaded but database entry failed.';
				
                } else {
					$absurl = 'http://' . gethostbyname(gethostname()) . '/FileUploadApi' . UPLOAD_PATH . $file_name;
					
                    $response['error'] = false;
                    $response['message'] = 'File Uploaded Successfullly';
                    $response['url'] = $absurl;
				}
 
            }
 
            break;
			
		case 'multiple_upload':
		
			$response['error'] = true;
			$response['message'] = 'Required parameters are not available';

			$files_arr = $_FILES['files'];
			if (!empty($files_arr)) {
				$util = new Util();
				$upload = new FileHandler();
				$urls = array();
				
				$files_desc = $util->reArrayFiles($files_arr);
				
				foreach ($files_desc as $file_desc) {
					$file = $file_desc['tmp_name'];
					$desc = "test multi file upload";
					
					$file_name = $upload->saveFile($file, $util->getFileExtension($file_desc['name']), $desc);
					if (strlen($file_name) > 0) {
						$absurl = 'http://' . gethostbyname(gethostname()) . '/FileUploadApi' . UPLOAD_PATH . $file_name;
						array_push($urls, $absurl);
					}
				}
				
				$response['error'] = false;
				$response['message'] = 'File Uploaded Successfullly';
				$response['urls'] = $urls;

			}

			break;
 
        case 'getFiles':
 
            $upload = new FileHandler();
            $response['error'] = false;
            $response['files'] = $upload->getAllFiles();
 
            break;
    }
}
 
echo json_encode($response);