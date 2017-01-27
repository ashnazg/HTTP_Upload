--TEST--
Uploaded file is too large (upload_max_filesize)
--CGI--
--INI--
upload_max_filesize=5
--POST--
MAX_FILE_SIZE=100000
--UPLOAD--
userfile=files/10b
--FILE--
<?php
error_reporting(E_ALL ^ E_STRICT);
if (file_exists('vendor/autoload.php')) {
    require_once 'vendor/autoload.php';
} else {
    require_once 'HTTP/Upload.php';
}
$up = new HTTP_Upload();
$file = $up->getFiles('userfile');
echo "Valid: ";   var_dump($file->isValid());
echo "Missing: "; var_dump($file->isMissing());
echo "Error: ";   var_dump($file->hasError());

var_dump($file->getProp());
?>
--EXPECTF--
Valid: bool(false)
Missing: bool(false)
Error: bool(true)
array(9) {
  ["real"]=>
  string(3) "10b"
  ["name"]=>
  string(3) "10b"
  ["form_name"]=>
  string(8) "userfile"
  ["ext"]=>
  NULL
  ["tmp_name"]=>
  string(0) ""
  ["size"]=>
  int(0)
  ["type"]=>
  string(0) ""
  ["error"]=>
  string(9) "TOO_LARGE"
  ["extra_ext"]=>
  array(0) {
  }
}
