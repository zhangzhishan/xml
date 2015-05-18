<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<body>
<link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
<div class="page-header">
  <h1>Genealogy Schema Design<small>A web demo</small></h1>
</div>
<ul class="nav nav-pills">
  <li role="presentation" ><a href="index.php">Home</a></li>
  <li role="presentation" ><a href="add.php">Add</a></li>
  <li role="presentation" ><a href="search.php">Search</a></li>
</ul>
<?php
$path='gen.xml';
$gen=new DOMDocument();
$gen->load($path);
$individualElements=$gen->getElementsByTagName('individual');
$cid=isset($_POST['id'])?$_POST['id']:0;
$halfid=isset($_POST['halfid'])?$_POST['halfid']:0;
if($cid>0 && $halfid>0) {
    if($cid==$halfid){
        exit('Intermarriage is not allowed!：：<a href=".">Back</a>');
    }
     if( GetF($individualElements,$cid)== GetF($individualElements,$halfid)){
         exit('Intermarriage is not allowed!：：<a href=".">Back</a>');
     }
    foreach($individualElements as $individual)
    {
        //a Divorce
        foreach ($individual->getElementsByTagName('cid') as $newcid) {
            if($newcid->nodeValue==$cid){
                foreach ($individual->getElementsByTagName('halfid') as $newhalfid) {
                    $newhalfid->nodeValue=$halfid;
                }
            }

            if($newcid->nodeValue==$halfid){
                foreach ($individual->getElementsByTagName('halfid') as $newhalfid) {
                    $newhalfid->nodeValue=$cid;
                }
            }
        }
    }
    if($gen->save($path)>0){
        exit('Marry Success!：：<a href=".">Back</a>');
    }else{
        exit('Marry Failed!：：<a href=".">Back</a>');
    }
}
function GetF($individualElements,$id){
	//Global $arr;
	foreach($individualElements as $individual) {
		foreach ($individual->getElementsByTagName('cid') as $cid) {
            $cid= $cid->nodeValue;
        }
	   foreach ($individual->getElementsByTagName('pid') as $pid) {
            $pid= $pid->nodeValue;
        }
        if($cid==$id){
        	if($pid==0){
        	     return $cid;
        	}
        		else{
        		// echo $pid."<br>";
        		$returnid=GetF($individualElements,$pid);
                if($returnid){
                	return $returnid;
                }
        	}
        }
	}
}

$id=isset($_GET['id'])?$_GET['id']:0;
$wantsex=isset($_GET['wantsex'])?$_GET['wantsex']:'Male';
$type=isset($_GET['type'])?$_GET['type']:'Married';
if($id){
        foreach($individualElements as $individual) {
            foreach ($individual->getElementsByTagName('cid') as $cid) {
                $cid= $cid->nodeValue;

                if($cid==$id){
                    foreach ($individual->getElementsByTagName('halfid') as $halfid) {
                        $halfid= $halfid->nodeValue;
                    }
                }
            }

        }



   		if ($halfid>0) {
   				if($type=="Married"){
                  exit('Cannot marry more than two times!：：<a href=".">Back</a>');
   				} else {

   					  foreach($individualElements as $individual)
                      {
                            foreach ($individual->getElementsByTagName('cid') as $newcid) {
                                if($newcid->nodeValue==$id){
                                       foreach ($individual->getElementsByTagName('halfid') as $newhalfid) {
                                        $newhalfid->nodeValue=0;
                                    }
                                }

                                if($newcid->nodeValue==$halfid){
                                    foreach ($individual->getElementsByTagName('halfid') as $newhalfid) {
                                        $newhalfid->nodeValue=0;
                                    }
                                }
                            }

   			          }
                    if($gen->save($path)>0){
                        exit('Divorce Success!：：<a href=".">Back</a>');
                    }else{
                        exit('Divorce Failed!：：<a href=".">Back</a>');
                    }


   		   }
   		}
   		if ($halfid==0) {
   				if($type=="Divorce"){
                  exit('Break marriage is unnecessary for a single one!：：<a href=".">Back</a>');
   				}
            foreach($individualElements as $individual)
            {
                foreach ($individual->getElementsByTagName('cid') as $newcid) {
                    $cid=$newcid-> nodeValue;
                    if($id!=$newcid->nodeValue){
                        foreach ($individual->getElementsByTagName('halfid') as $half) {
                            $halfid=$half-> nodeValue;

                        }
                        foreach ($individual->attributes as $attr) {
                            $arr[$attr->nodeName] = $attr->nodeValue;
                        }
                        if($arr['sex']==$wantsex && $halfid==0){
                            $newarr[]=array('id'=>$cid,'name'=>$arr['name'].' '.$arr['lastname']);
                        }
                    }
                }
            }}
            ?>

<form action="" method="post">
    <input type="hidden" value="<?php echo $id;?>" name="id">
    <select name='halfid'>
        <?php foreach ($newarr as $item) {
            ?>
            <option value="<?php
    echo $item['id'];?>"><?php echo $item['name'] ?></option>
        <?php  }
?>


    </select>
    <input type="submit" value="Choose the one to marry with">
</form>
<?php
}
exit('choose again：：<a href=".">Back</a>');?>
</body></html>
