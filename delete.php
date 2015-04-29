<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
$path='persons.xml';
$persons=new DOMDocument();
$persons->load($path);
$personElements=$persons->getElementsByTagName('person');
if(isset($_GET['id'])) {

    foreach ($personElements as $person) {
        foreach ($person->getElementsByTagName('pid') as $newcid) {
            if ($newcid->nodeValue == $_GET['id']) {
                exit('Cannot delete the branch with sub-element：：<a href=".">Back</a>');
            }
        }
    }

    $i = 0;
    foreach ($personElements as $person) {
        foreach ($person->getElementsByTagName('cid') as $cid) {
            $cid = $cid->nodeValue;
        }
            if ($cid == $_GET['id']) {
                $deleteitem = $personElements->item($i);
                $deleteitem->parentNode->removeChild($deleteitem);
            }
            $i++;
        }
        if ($persons->save($path) > 0) {
            exit('Delete Success!：：<a href=".">Back</a>');
        } else {
            exit('Delete Failed!：：<a href=".">Back</a>');
        }

}
