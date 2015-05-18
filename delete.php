<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
$path='gen.xml';
$gen=new DOMDocument();
$gen->load($path);
$individualElements=$gen->getElementsByTagName('individual');
if(isset($_GET['id'])) {

    foreach ($individualElements as $individual) {
        foreach ($individual->getElementsByTagName('pid') as $newcid) {
            if ($newcid->nodeValue == $_GET['id']) {
                exit('Cannot delete the branch with sub-element：：<a href=".">Back</a>');
            }
        }
    }

    $i = 0;
    foreach ($individualElements as $individual) {
        foreach ($individual->getElementsByTagName('cid') as $cid) {
            $cid = $cid->nodeValue;
        }
            if ($cid == $_GET['id']) {
                $deleteitem = $individualElements->item($i);
                $deleteitem->parentNode->removeChild($deleteitem);
            }
            $i++;
        }
        if ($gen->save($path) > 0) {
            exit('Delete Success!：：<a href=".">Back</a>');
        } else {
            exit('Delete Failed!：：<a href=".">Back</a>');
        }

}
