<?php 

namespace App\Util;

class Logger {

    public function __construct()
    {
    }

    public static function logger($path, $msg) 
    {
        $path = explode(".", $path);
        $forder_path = '../storage/logs/';
        foreach($path as $folder) {
            $forder_path.= $folder."_log/";
            if(file_exists($forder_path) === false) {
                mkdir($forder_path, 0777);
            }
        }

        $fp = fopen($forder_path.date('Ymd').".log", 'a');
        fwrite($fp, $msg."\r\n");
        fclose($fp);
    }
}
?>
