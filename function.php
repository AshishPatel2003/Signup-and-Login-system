<?php

// Renaming the file name of image.
function renamefilename($id, $filetype){
    $ext = '';
    if ($filetype == "image/jpeg") {
        $ext = '.jpeg';
    } elseif ($filetype == "image/jpg") {
        $ext = ".jpg";
    } elseif ($filetype == "image/png") {
        $ext = ".png";
    } elseif ($filetype == "image/gif") {
        $ext = ".gif";
    }
    return $id . $ext;
}

?>
