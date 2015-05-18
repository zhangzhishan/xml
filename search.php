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
<link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
<div class="page-header">
  <h1>Genealogy Schema Design<small>A web demo</small></h1>
</div>
<ul class="nav nav-pills">
  <li role="presentation" ><a href="index.php">Home</a></li>
  <li role="presentation" ><a href="add.php">Add</a></li>
  <li role="presentation" class="active"><a href="search.php">Search</a></li>
</ul>
<div class="input-group">
    <form action="search.php" >
      <span class="input-group-addon">Last Name</span>
      <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)" name="search" value="">
      <span class="input-group-addon"><input type="submit" value="search"></span>
    </form>
</div>
<!--lTREEMenu Start:-->
<div class="lTREEMenu lTREENormal" id="lTREEMenuDEMO">
<?php
$path='gen.xml';
$gen=new DOMDocument();
$gen->load($path);
$individualElements=$gen->getElementsByTagName('individual');
$arrs=array();
foreach($individualElements as $individual) {
    foreach ($individual->attributes as $attr) {
        $arr[$attr->nodeName] = $attr->nodeValue;
    }
    foreach ($individual->getElementsByTagName('pid') as $pid) {
        $arr['pid']= $pid->nodeValue;
    }
    foreach ($individual->getElementsByTagName('cid') as $cid) {
        $arr['id'] = $cid->nodeValue;
    }
    $arrs[]=$arr;
   /*if($arr['lastname']==$_GET['search']){

        $arr['name']= $cid."&nbsp;".$arr['lastname']. $arr['name'].'|'. $arr['sex'].'|'.$arr['birthday'];

        $arrs[]=array( "id"=> $arr['id']  ,'name'=>$arr['name']);

    }*/
}
foreach($arrs as $item){

    if ($_GET) {
        if($item['lastname']==$_GET['search']){

       $name= $item['id']."&nbsp;". $item['name'].' '.$item['lastname'].'|'. $item['sex'].'|'.$item['birthday'];
      echo "<dl>".$name."</dl>";

    }

    }
    

}



?>
</div>

</body>
</html>
