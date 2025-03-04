<?php
if (!function_exists("deleteFilesFromDirectory")) {
function deleteFilesFromDirectory($directory, $file_type = '*.*'){
    foreach(glob($directory . '/' . $file_type) as $filename) {
         unlink($filename);
    }
}   
}
