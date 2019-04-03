<?php
include 'sparrow.php';
// Declare the class instance
$db = new Sparrow();


/**
$sql = mysql_connect('localhost', 'semuahos_pempek', 'pempek123456');

mysql_select_db('semuahos_pempek');

$db->setDb($sql);
**/



/**
$sql = mysql_connect('localhost', 'root', 'R4h45ia');

mysql_select_db('pempek');

$db->setDb($sql);
**/
/**
$sql = mysqli_connect('localhost', 'root', '','belajarcrud');
//$sql = mysqli_connect('localhost', 'berc5989_bendajaya', '.nbC;IxZr.UX','berc5989_bendajaya');


$db->setDb($sql);
**/
/**
 if($tujuan!="konfirmlogin" and $tujuan !="lihathalaman"){

$couser=$_SESSION["userpempek"];
$copass=$_SESSION["passpempek"];

if(!empty($_SESSION["userpempek"])){
$row = $db->from('tb_user')
    ->where('username', $couser)
    ->where('password', $copass)
    ->many();

$ketemu=count($row);
}
//print("jumlah : ".count($row));

if($ketemu>0){
$sudahlogin=1;


}else{
$sudahlogin=0;
print("<a href=login.php>KLIK DISINI UNTUK LOGIN</a>");
echo "<script LANGUAGE=\"JavaScript\">
<!--
window.location=\"login.php\";
// -->
</script>";

exit();

}


 }


$url=$_SERVER[REQUEST_URI];
$aurl=explode("/",$url);
$mainfile="";
if($aurl[count($aurl)-2]!=""){
$mainfile=$aurl[count($aurl)-2];
}else{
$mainfile=$aurl[count($aurl)-1];
}
$mainword=$mainfile;
$mainfile=$mainfile.".php";
**/

?>
