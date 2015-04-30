<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<body>
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
$path='persons.xml';
$persons=new DOMDocument();
$persons->load($path);
$personElements=$persons->getElementsByTagName('person');
if(isset($_GET['pid'])){
    foreach($personElements as $person){
        foreach ($person->getElementsByTagName('cid') as $cid) {
            $cid = $cid->nodeValue;
        }
        if (!preg_match("/^\d{4}-\d{1,2}-\d{1,2}$/",$_GET['birthday'])){
            exit('Date type is not allowed!');
        }
        if($cid==$_GET['id']){
            if($_GET['pid']!=0){
                foreach($personElements as $person){
                    foreach ($person->getElementsByTagName('cid') as $newcid) {
                        if($newcid->nodeValue==$_GET['pid']){
                            foreach ($person->attributes as $attr) {
                                $arr[$attr->nodeName] = $attr->nodeValue;
                            }
                            if(strtotime( $arr['birthday'])>= strtotime($_GET['birthday'])){
                                exit('The ancestor should be born earlier than the child!：：<a href=".">Back</a>');
                            }
                        }
                    }
                }
            }
            foreach ($person->attributes as $attr) {
                if($attr->nodeName=='first'){
                    $attr->nodeValue=$_GET['first'];
                }
                if($attr->nodeName=='name'){
                    $attr->nodeValue=$_GET['name'];
                }
                if($attr->nodeName=='first'){
                    $attr->nodeValue=$_GET['first'];
                }
                if($attr->nodeName=='sex'){
                    $attr->nodeValue=$_GET['sex'];
                }
                if($attr->nodeName=='birthday'){
                    $attr->nodeValue=$_GET['birthday'];
                }
        }
        }

    }
    if($persons->save($path)>0){
        exit('Edit success：：<a href=".">Back</a>');
    }else{
        exit('Edit Failed!：：<a href=".">Back</a>');
    }
}
foreach($personElements as $person) {
    foreach ($person->getElementsByTagName('cid') as $cid) {
        $cid = $cid->nodeValue;
    }
   if($cid==$_GET['id']){
       foreach ($person->getElementsByTagName('pid') as $pid) {
           $pid= $pid->nodeValue;
       }
       foreach ($person->attributes as $attr) {
           $arr[$attr->nodeName] = $attr->nodeValue;
       }
   }
}
?>
<form   action="">
    <input type="hidden" name="id" value="<?php echo isset($_GET['id'])?$_GET['id']:0?>">
    The last branch:<?php echo isset($_GET['id'])?"":"The last branch"?><input type="hidden" name="pid" value="<?php echo $pid ?>"><br>
    Last name<input type="input"  name="first" value="<?php echo $arr['first']?>">First name<input type="input"  name="name" value="<?php echo $arr['name']?>"><br>
    Sex<select name="sex">
        <option value="Male" <?php if($arr['sex']=="Male"){echo "selected";}?>>Male</option>
        <option value="Female" <?php if($arr['sex']=="Female"){echo "selected";}?>>Female</option>
    </select><br>
    Date of Birthday<input type="input"  name="birthday"  value="<?php echo $arr['birthday']?>"><br>
    <input type="submit">
</form>
</body>
</html>
