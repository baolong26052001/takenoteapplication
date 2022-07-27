<?php
// check file for errors and return false if there are errrors
// or return the file path if it is ok
function checkFile($file, $type, &$errors, $maxsize = 5000000) {
  $file = $file['image'];
  $fname = $file['name'];
  $ftype = explode("/", $file['type']);
  $tmp_name = $file['tmp_name'];
  $error = $file['error'];
  $fsize = $file['size'];
  $allowed_ext = fileExt($type);
  if($error == 0) {

    // #1 check file ext
    if(!in_array(end($ftype), $allowed_ext) || $type != $ftype[0]) {
      $errors['fext'] = "Only {$type} file types allowed!";
    }
    // #2 check file size
    if($fsize > $maxsize) {
      $errors['fsize'] = "The file is too large.";
    }
    // if the $errors[] empty move the file from temp dir to final dir
    if(empty($errors)) {
      $new_fname = uniqid('', false) . "." . end($ftype);
      $final_path = "image/" . $new_fname;
      if(move_uploaded_file($tmp_name, $final_path)) {
        return $final_path;
      } else {
        $errors['fmove'] = "There was a problem uploading the file.";
        return false;
      }

    }


  } else {
    $errors['fError'] = "The was an error with the file.";
  }
}

function fileExt($type) {
  if($type == "image") {
    return ['png','jpeg', 'jpg', 'gif'];
  } elseif ($type == "video") {
    return ['mp4','mov', 'avi','wmv'];
  }
}