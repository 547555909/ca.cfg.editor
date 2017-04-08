<?PHP
####################################################
#                                                  #
# CA Config Editor copyright 2017, Andrew Zawadzki #
#                                                  #
####################################################

function readCFGfile($filename) {
  $data['contents'] = @file_get_contents($filename);
  if ($data['contents'] === false) {
    $data['error'] = "true";
  }
  $data['format'] = (strpos($data['contents'],"\r\n")) ? "dos" : "linux";
  $data['contents'] = str_replace("\r","",$data['contents']);
  return $data;
}

switch ($_POST['action']) {
  case 'edit':
    $filename = urldecode($_POST['filename']);
    echo json_encode(readCFGfile($filename));
    break;
  case 'save':
    $filedata = $_POST['filedata'];
    $backupContents = file_get_contents($filedata['filename']);
    file_put_contents("{$filedata['filename']}.bak",$backupContents);
    if ( $filedata['format'] == "true" ) {
      $filedata['contents'] = str_replace("\n","\r\n",$filedata['contents']);
    }
    file_put_contents($filedata['filename'],$filedata['contents']);
    file_put_contents("/tmp/huh","{$filedata['filename']}\n$contents");
    echo "ok";
    file_put_contents("/tmp/huh1",print_r($filedata,true));
    break;
  case 'getBackup':
    $filename = urldecode($_POST['filename']);
    if (is_file("$filename.bak") ) {
      echo file_get_contents("$filename.bak");
    } else {
      echo "No Backup File Found";
    }
    break;
}
?>
