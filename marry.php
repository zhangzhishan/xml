<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<body>
<?php
$path='persons.xml';
$persons=new DOMDocument();
$persons->load($path);
$personElements=$persons->getElementsByTagName('person');
$cid=isset($_POST['id'])?$_POST['id']:0;
$halfid=isset($_POST['halfid'])?$_POST['halfid']:0;
if($cid>0 && $halfid>0) {
    if($cid==$halfid){
        exit('Intermarriage is not allowed!：：<a href=".">Back</a>');
    }
     if( GetF($personElements,$cid)== GetF($personElements,$halfid)){
         exit('Intermarriage is not allowed!：：<a href=".">Back</a>');
     }
    foreach($personElements as $person)
    {
        //a Divorce
        foreach ($person->getElementsByTagName('cid') as $newcid) {
            if($newcid->nodeValue==$cid){
                foreach ($person->getElementsByTagName('halfid') as $newhalfid) {
                    $newhalfid->nodeValue=$halfid;
                }
            }

            if($newcid->nodeValue==$halfid){
                foreach ($person->getElementsByTagName('halfid') as $newhalfid) {
                    $newhalfid->nodeValue=$cid;
                }
            }
        }
    }
    if($persons->save($path)>0){
        exit('Marry Success!：：<a href=".">Back</a>');
    }else{
        exit('Marry Failed!：：<a href=".">Back</a>');
    }
}
function GetF($personElements,$id){
	//Global $arr;
	foreach($personElements as $person) {
		foreach ($person->getElementsByTagName('cid') as $cid) {
            $cid= $cid->nodeValue;
        }
	   foreach ($person->getElementsByTagName('pid') as $pid) {
            $pid= $pid->nodeValue;
        }
        if($cid==$id){
        	if($pid==0){
        	     return $cid;
        	}
        		else{
        		// echo $pid."<br>";
        		$returnid=GetF($personElements,$pid);
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
        foreach($personElements as $person) {
            foreach ($person->getElementsByTagName('cid') as $cid) {
                $cid= $cid->nodeValue;

                if($cid==$id){
                    foreach ($person->getElementsByTagName('halfid') as $halfid) {
                        $halfid= $halfid->nodeValue;
                    }
                }
            }

        }



   		if ($halfid>0) {
   				if($type=="Married"){
                  exit('Cannot marry more than two times!：：<a href=".">Back</a>');
   				} else {

   					  foreach($personElements as $person)
                      {
                            foreach ($person->getElementsByTagName('cid') as $newcid) {
                                if($newcid->nodeValue==$id){
                                       foreach ($person->getElementsByTagName('halfid') as $newhalfid) {
                                        $newhalfid->nodeValue=0;
                                    }
                                }

                                if($newcid->nodeValue==$halfid){
                                    foreach ($person->getElementsByTagName('halfid') as $newhalfid) {
                                        $newhalfid->nodeValue=0;
                                    }
                                }
                            }

   			          }
                    if($persons->save($path)>0){
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
            foreach($personElements as $person)
            {
                foreach ($person->getElementsByTagName('cid') as $newcid) {
                    $cid=$newcid-> nodeValue;
                    if($id!=$newcid->nodeValue){
                        foreach ($person->getElementsByTagName('halfid') as $half) {
                            $halfid=$half-> nodeValue;

                        }
                        foreach ($person->attributes as $attr) {
                            $arr[$attr->nodeName] = $attr->nodeValue;
                        }
                        if($arr['sex']==$wantsex && $halfid==0){
                            $newarr[]=array('id'=>$cid,'name'=>$arr['first'].$arr['name']);
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
    echo $item['id'];?>"><?php echo $item['firs'].$item['name'] ?></option>
        <?php  }
?>


    </select>
    <input type="submit" value="Choose the one to marry with">
</form>
<?php
}
exit('choose again：：<a href=".">Back</a>');?>
</body></html>
