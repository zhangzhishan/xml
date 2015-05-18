<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" lang="en"/>
<link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
<body>

<div class="page-header">
  <h1>Genealogy Schema Design<small>A web demo</small></h1>
</div>
<ul class="nav nav-pills">
  <li role="presentation" ><a href="index.php">Home</a></li>
  <li role="presentation" class="active"><a href="add.php">Add</a></li>
  <li role="presentation"><a href="search.php">Search</a></li>
</ul>
<div class="lTREEMenu lTREENormal" id="lTREEMenuDEMO">
<?php
$path='gen.xml';
$gen=new DOMDocument();
$gen->load($path);
if(isset($_GET['pid'])){
    $individualElements=$gen->getElementsByTagName('individual');
    foreach($individualElements as $individual){
       foreach ($individual->getElementsByTagName('cid') as $newcid) {
            $cids[] = $newcid->nodeValue;
        }
    }




    if (!preg_match("/^\d{4}-\d{1,2}-\d{1,2}$/",$_GET['birthday'])){
        exit('Date Type is wrong!');
    }
   // strtotime("2007-3-5")
    if($_GET['pid']!=0){



        foreach($individualElements as $individual){
            foreach ($individual->getElementsByTagName('cid') as $newcid) {
             if($newcid->nodeValue==$_GET['pid']){
                 foreach ($individual->attributes as $attr) {
                     $arr[$attr->nodeName] = $attr->nodeValue;
                 }
                 if(strtotime( $arr['birthday'])>= strtotime($_GET['birthday'])){
                     exit('The DOB of the ancestor should earlier than the child：：<a href=".">Back</a>');
                 }
             }
            }
        }
    }

        $individual=$gen->createElement('individual'); #create the new element
        $individual->setAttribute('lastname',$_GET['lastname']);
        $individual->setAttribute('name',$_GET['name']);
        $individual->setAttribute('sex',$_GET['sex']);
        $individual->setAttribute('birthday',$_GET['birthday']);

        $cid=$gen->createElement('cid');# create the sub-element
        $cid->nodeValue =max($cids)+1;

        $individual->appendChild($cid);#append the child element to the father element
        $pid=$gen->createElement('pid');# create the child element
        $pid->nodeValue=$_GET['pid'];
        $individual->appendChild($pid);#add the child element to the father element
    $gen->documentElement->appendChild($individual);#add the whole branch
    if($gen->save($path)>0){
        exit('Add success：：<a href=".">Back</a>');
    }else{
        exit('Add wrong：：<a href=".">Back</a>');
    }

}
?>
<form   action="" method="get">
   Last branch:<?php echo isset($_GET['id'])?"":"The top branch"?><input type="hidden" name="pid" value="<?php echo isset($_GET['id'])?$_GET['id']:0?>"><br>
   Last name<input type="input"  name="lastname">First name<input type="input"  name="name"><br>
    Sex<select name="sex">
        <option value="Male">Male</option>
        <option value="Female">Female</option>
    </select><br>
    Date of Birthday<input type="input"  name="birthday"><br>
    <input type="submit">
</form>
</body>
</html>
