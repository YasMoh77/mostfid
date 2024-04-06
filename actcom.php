<?php
ob_start();
session_start();
$title='حذف تعليق  ';  //title of the page
?><link rel="canonical" href="https://mostfid.com/index.php" >
<meta name="robots" content="noindex">
<?php
include 'init.php';

 if (isset($_SESSION['traderid'])) { $session=$_SESSION['traderid']; } //trader
 elseif (isset($_SESSION['userEid'])) { $session=$_SESSION['userEid']; } //user email
elseif (isset($_SESSION['userGid'])) { $session=$_SESSION['userGid']; } //user google
elseif (isset($_SESSION['userFid'])) { $session=$_SESSION['userFid']; } //user fb

if (isset($session)) {
  
//delete comment coming from => details.php & formComment.php
  if ( isset($_GET['c'])&&is_numeric($_GET['c']) && $_GET['c']>0 && isset($_GET['i']) && is_numeric($_GET['i']) && $_GET['i']>0 && isset($_GET['t']) && ($_GET['t']=='sg'||$_GET['t']=='sv'||$_GET['t']=='ig'||$_GET['t']=='iv'||$_GET['t']=='p'||$_GET['t']=='admin') ) { 
   	$comment=intval($_GET['c']);
    $item=intval($_GET['i']);
    $t=$_GET['t'];
     ?>
     <div class="above bottom2">
       <span class="spinner-border spinner-border-del"></span>
     </div> 
     <?php
     	$stmt=$conn->prepare(" DELETE  from comments where c_id=:id  ");
      $stmt->bindParam(':id',$comment );
      $stmt->execute();
      if ($stmt) {
    	?> <script>window.location.href='details.php?id=<?php echo $item;?>&<?php if($t=='sg'){ echo 't=s&main=g#show'; }elseif($t=='sv'){ echo 't=s&main=v#show';}elseif($t=='ig'){ echo 't=i&main=g#show';}elseif($t=='iv'){ echo 't=i&main=v#show';}elseif($t=='p'){ echo 't=p&main=p';}elseif($t=='admin'){ echo 't=admin&main=admin';} ?>';</script> <?php
    }
  }else{ //END if(isset($_GET['c']))
    include 'notFound.php';
  }

}//END if isset($session)



include  $tmpl ."footer.inc";
include 'foot.php';
 ob_end_flush();
