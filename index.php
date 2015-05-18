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
<link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
<style type="text/css">
#lTREEMenuDEMO {width:100%;border:1px solid #ccc;margin:3px;padding:3px;}
#infoBox {position:absolute;left:450px;top:40px;border:1px solid #ccc;width:400px;padding:0 10px;font-family:Geneva,Arial,sans-serif;line-height:150%;}
#debugMSG strong {color:#f00;}
.button{
    font-weight: bold;
    text-transform: uppercase;
    font-family: verdana;
    border: 1px solid #282727;
    font-size: 1.2em;
    line-height: 1.25em;
    padding: 3px 10px;
    border-radius: 12px;
    -moz-border-radius: 12px;
    -webkit-border-radius: 12px;
    box-shadow: 1px 2px 3px #555;
    -moz-box-shadow: 1px 2px 3px #555;
    -webkit-box-shadow: 1px 2px 3px #555;
}
.contents{
    font-weight: bold;
    background-color: #00ff00;
    text-transform: uppercase;
    font-family: verdana;
    border: 1px solid #282727;
    font-size: 1.2em;
    line-height: 1.25em;
    padding: 3px 10px;
    border-radius: 12px;
    -moz-border-radius: 12px;
    -webkit-border-radius: 12px;
    box-shadow: 1px 2px 3px #555;
    -moz-box-shadow: 1px 2px 3px #555;
    -webkit-box-shadow: 1px 2px 3px #555;
}
body{
    margin:auto;width:1600px; border:solid 1px #000;
}
</style>
<!--[if IE 6]>
<script>
document.execCommand("BackgroundImageCache", false, true);
</script>
<![endif]-->
</head>
<body>
<!--lTREEMenu Start:-->
<div class="page-header">
  <h1>Genealogy Schema Design<small>A web demo</small></h1>
</div>
<ul class="nav nav-pills">
  <li role="presentation" class="active"><a href="index.php">Home</a></li>
  <li role="presentation"><a href="add.php">Add</a></li>
  <li role="presentation"><a href="search.php">Search</a></li>
  <li role="presentation"><a href="gen.xml">XML Output</a></li>
</ul>
<div class="lTREEMenu lTREENormal" id="lTREEMenuDEMO">
<?php
$path='gen.xml';
$gen=new DOMDocument();
$gen->load($path);
$individualElements=$gen->getElementsByTagName('individual');
        foreach($individualElements as $individual){
             foreach ($individual->getElementsByTagName('cid') as $cid) {
                $cid= $cid->nodeValue;
            }
           foreach ($individual->attributes as $attr) {
                $arr[$attr->nodeName] = $attr->nodeValue;
            }
        $halfarr[$cid]=$arr['lastname'].$arr['name'];
        }
function persionmenu($individualElements,$preid=0,$halfarr){
    echo "<br />";
    foreach($individualElements as $individual) {
        foreach ($individual->getElementsByTagName('pid') as $pid) {
            $pid= $pid->nodeValue;
        }
        foreach ($individual->getElementsByTagName('cid') as $cid) {
            $cid = $cid->nodeValue;
        }

        foreach ($individual->getElementsByTagName('halfid') as $halfid) {
            $halfid = $halfid->nodeValue;
        }
        if($halfid>0){
            $will="Divorce";
        	$marry="Married";
        }else{
            $will="Marry";
        	$marry="Single";
        }
        if($preid==$pid){
            echo "<dl>";
            $arr = array();
            foreach ($individual->attributes as $attr) {
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
            echo '<span class="contents">'.$cid."&nbsp;".$arr['lastname']. $arr['name'].$other.'|'.$marry.'|'. $arr['sex'].'|'.$arr['birthday'].'</span>'.'<a class="button" href=marry.php?wantsex='.$wantsex.'&type='.$will.'&id='.$cid.'>'.$will.'</a><a href=add.php?id='.$cid.' class="button">Add</a><a href=modify.php?id='.$cid.' class="button">Modify</a><a href=delete.php?id='.$cid.' class="button">Delete</a>';
            echo "<br />";
            persionmenu($individualElements,$cid,$halfarr);
            echo "</dl>";
        }
        
    }
}
persionmenu($individualElements,0,$halfarr);
?>
</div>

</body>
</html>
