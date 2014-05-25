<?php
class AjaxAction extends CommonAction{

    // Demo 上传
    public function demoUpload() {
        import('ORG.Util.UploadHandler');
        import('ORG.Util.PclZip');

        $options = array(
            'script_url' => C('WEB_URL').'/Admin/Ajax/demoUpload/',
            'upload_dir' => C('WEB_ROOT').'/Uploads/demos/'.$_SESSION['_adminUser']['uid'].'/',
            'upload_url' => C('WEB_URL').'/Uploads/demos/'.$_SESSION['_adminUser']['uid'].'/',
            'accept_file_types' => '/\.(zip)$/i',
            'is_unzip' => true
        );

        $upload_handler = new UploadHandler($options);

    }

}


?>