<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
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
#infoBox {position:absolute;left:450px;top:40px;border:1px solid #ccc;width:400px;padding:0 10px;font-family:"ËÎÌå",Geneva,Arial,sans-serif;line-height:150%;}
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

    <form action="search.php" >
    <dl>Last name<input type="text" value="" name="search"> <input type="submit" value="search"> </dl>
    </form>

<?php
$path='persons.xml';
$persons=new DOMDocument();
$persons->load($path);
$personElements=$persons->getElementsByTagName('person');
$arrs=array();
foreach($personElements as $person) {
    foreach ($person->attributes as $attr) {
        $arr[$attr->nodeName] = $attr->nodeValue;
    }
    foreach ($person->getElementsByTagName('pid') as $pid) {
        $arr['pid']= $pid->nodeValue;
    }
    foreach ($person->getElementsByTagName('cid') as $cid) {
        $arr['id'] = $cid->nodeValue;
    }
    $arrs[]=$arr;
   /*if($arr['first']==$_GET['search']){

        $arr['name']= $cid."&nbsp;".$arr['first']. $arr['name'].'|'. $arr['sex'].'|'.$arr['birthday'];

        $arrs[]=array( "id"=> $arr['id']  ,'name'=>$arr['name']);

    }*/
}
foreach($arrs as $item){
    if($item['first']==$_GET['search']){

       $name= $item['id']."&nbsp;".$item['first']. $item['name'].'|'. $item['sex'].'|'.$item['birthday'];
      echo "<dl>".$name."</dl>";

    }

}



?>
    <dl><a href=".">Back</a>
    </dl>
</div>

</body>
</html>