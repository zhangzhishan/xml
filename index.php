<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>XML</title>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<meta name="generator" content="editplus" />
<meta name="author" content="" />
<meta name="keywords" content="" />
<meta name="description" content="" />
<link type="text/css" rel="stylesheet" href="lTREE.2.css" />
<style type="text/css">
#lTREEMenuDEMO {width:100%;border:1px solid #ccc;margin:3px;padding:3px;}
#infoBox {position:absolute;left:450px;top:40px;border:1px solid #ccc;width:400px;padding:0 10px;font-family:Geneva,Arial,sans-serif;line-height:150%;}
#debugMSG strong {color:#f00;}
</style>
<!--[if IE 6]>
<script>
document.execCommand("BackgroundImageCache", false, true);
</script>
<![endif]-->
</head>
<body>
<!--lTREEMenu Start:-->
<div class="lTREEMenu lTREENormal" id="lTREEMenuDEMO">
    <form action="search.php">
    <dl>Last name<input type="text" name="search" value=""> <input type="submit" value="search"> <a href="add.php">Add</a> </dl>
    </form>
<?php
$path='persons.xml';
$persons=new DOMDocument();
$persons->load($path);
$personElements=$persons->getElementsByTagName('person');
        foreach($personElements as $person){
             foreach ($person->getElementsByTagName('cid') as $cid) {
                $cid= $cid->nodeValue;
            }
           foreach ($person->attributes as $attr) {
                $arr[$attr->nodeName] = $attr->nodeValue;
            }
        $halfarr[$cid]=$arr['first'].$arr['name'];
        }
function persionmenu($personElements,$preid=0,$halfarr){
    foreach($personElements as $person) {
        foreach ($person->getElementsByTagName('pid') as $pid) {
            $pid= $pid->nodeValue;
        }
        foreach ($person->getElementsByTagName('cid') as $cid) {
            $cid = $cid->nodeValue;
        }

        foreach ($person->getElementsByTagName('halfid') as $halfid) {
            $halfid = $halfid->nodeValue;
        }
          if ($arr['name']=="Male") {
            $wantsex ="Female";
          }
        if($halfid>0){
            $will="Divorce";
        	$marry="Married";
        }else{
            $will="Marry";
        	$marry="Single";
        }
        echo "<dl>";
        if($preid==$pid){
            $arr = array();
            foreach ($person->attributes as $attr) {
                $arr[$attr->nodeName] = $attr->nodeValue;
            }
            if ($arr['sex']=="Male") {
            $wantsex ="Female";
            }else{$wantsex="Male";}
            if($halfid!=0){
                //$other=$halfarr[$halfid];
                $other='|Couple:'.$halfarr[$halfid];
            }else{
                $other='';
            }
            echo $cid."&nbsp;".$arr['first']. $arr['name'].$other.'|'.$marry.'|'. $arr['sex'].'|'.$arr['birthday'].'|[<a href=marry.php?wantsex='.$wantsex.'&type='.$will.'&id='.$cid.'>'.$will.'</a>][<a href=add.php?id='.$cid.'>Add</a>][<a href=modify.php?id='.$cid.'>Modify</a>][<a href=delete.php?id='.$cid.'>Delete</a>]';
            persionmenu($personElements,$cid,$halfarr);
        }
        echo "</dl>";
    }
}
persionmenu($personElements,0,$halfarr);
?>
</div>

</body>
</html>
