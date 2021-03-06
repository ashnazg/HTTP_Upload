--TEST--
Uploaded file is too large (post_max_size)
--CGI--
--INI--
post_max_size=5
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
    set_include_path(get_include_path() . PATH_SEPARATOR . __DIR__ . '/../');
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
Warning: POST Content-Length of 338 bytes exceeds the limit of 5 bytes in Unknown on line 0
Valid: bool(false)
Missing: bool(false)
Error: bool(true)
array(9) {
  ["real"]=>
  string(6) "_error"
  ["name"]=>
  string(6) "_error"
  ["form_name"]=>
  NULL
  ["ext"]=>
  NULL
  ["tmp_name"]=>
  NULL
  ["size"]=>
  NULL
  ["type"]=>
  NULL
  ["error"]=>
  string(9) "TOO_LARGE"
  ["extra_ext"]=>
  array(0) {
  }
}
