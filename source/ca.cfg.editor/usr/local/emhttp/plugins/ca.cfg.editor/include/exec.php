<?PHP

switch ($_POST['action']) {
  case 'edit':
    $filename = urldecode($_POST['filename']);
    if ( ! is_file($filename) ) {
      return;
    }
    echo file_get_contents($filename);
    break;
  case 'save':
    $filename = urldecode($_POST['filename']);
    $contents = urldecode($_POST['contents']);
    $backupContents = file_get_contents($filename);
    file_put_contents("$filename.bak",$backupContents);
    file_put_contents($filename,$contents);
    echo "ok";
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
