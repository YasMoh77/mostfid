<?php
ob_start();
session_start();
//abbreviations
$tmpl='include/templates/';
$css='layout/css/';
$js='layout/js/';
$images='layout/images/';
$fonts='layout/fonts/';
$language='include/languages/';
$func='include/functions/';
//important files
include 'lang.php'; //must be before header or header words fail.
include $tmpl."header.inc";
include 'connect.php'; //this file connects to database
include $func.'functions.php';


  if (isset($_SESSION['traderid'])) { $session=$_SESSION['traderid']; } //trader
 elseif (isset($_SESSION['userEid'])) { $session=$_SESSION['userEid']; } //user email
elseif (isset($_SESSION['userGid'])) { $session=$_SESSION['userGid']; } //user google
elseif (isset($_SESSION['userFid'])) { $session=$_SESSION['userFid']; } //user fb

          //inserting comments
if (isset($session) ) {//IF THERE IS A SESSION receive formComment from details.php
		if ($_SERVER['REQUEST_METHOD']=='POST') {

			$comment =filter_var(trim($_POST['comment']), FILTER_SANITIZE_STRING);
		 	$userid  =$session;//session owner [commentor]
		 	$itemid  =$_POST['itemid'];//item
		 	$token   =$_POST['token']; 
          //  $itemUser=$_POST['itemUser'];//user who posted the item
          //  $thumb   =isset($_POST['thumb']);
            $date    =date('Y-m-d');
            $l       =$_POST['lng'];

	     		$stmt=$conn->prepare("
	                  INSERT INTO comments(c_text,c_date,user_id,item_id)
	                                VALUES(:zcomment,:zdate,:zuser,:zitem)");
	     		$stmt->execute(array(
	     			'zcomment' =>$comment,
	     			'zdate'    =>$date,
	     			'zuser'    =>$userid,
	     			'zitem'    =>$itemid,
	     		     ));
		         		
		         		if ($stmt) {
		         		$stmtD=$conn->prepare(" DELETE from comments where c_text=' '  ");
		         		$stmtD->execute();	
						/////////////////////
						?><span class="span-no-comments "><?php echo $lang['byUsers']?></span><?php
				   		 // users comments
				   		 $userComments=countFromDb2('c_id','comments','ITEM_ID',$itemid); 
				   		 echo '( '.$userComments.' '.$lang['comment'].' )'; 

					        //pagination data
						     $adsPerPage=10;
							 $NumberOfPages=ceil($userComments/$adsPerPage);
						     $pageNum= isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page']<=$NumberOfPages&& $_GET['page']>0 ? intval($_GET['page']) : 1;
						     $startFrom=($pageNum-1)* $adsPerPage; //

					        $stmt=$conn->prepare("SELECT items.*,user.*,comments.* FROM comments
					        JOIN user ON user.user_id=comments.user_id
					        JOIN items ON items.item_id=comments.item_id
					        WHERE items.item_id=? 
							ORDER BY comments.c_id DESC limit $startFrom, $adsPerPage ");
							$stmt->execute(array($itemid));
							$fetched3=$stmt->fetchAll();
							$count3=$stmt->rowCount();

							foreach ($fetched3 as  $com) {  ?>
								<!-- get url to decide ts or ti -->
							   	 <?php  
							   	 if($token==1){ $go="&t=s&main=g#show";}elseif($token==2){ $go="&t=s&main=v#show";}
							   	 elseif($token==3){ $go="&t=i&main=g#show";}elseif($token==4){ $go="&t=i&main=v#show";}
							   	 elseif($token==5){ $go="&t=p&main=p#show";}elseif($token==6){ $go="&t=admin&main=admin#show";}
						   		 ?>
								<?php// $url= $_SERVER['REQUEST_URI']; /*get url*/ $pr=  preg_match('/t=s/', $url); //use for details pathinfo?>
							   	<!--------///////////------------------->
							   	 <div class="container-comm" id="comment">
							   			 <div class="div-comm-1">
								   		     <div class="name-date-dots">   
								   		    	<section>
								   		    		<span class='span-black-homepage-comment cut2'><?php echo $com['name']; ?></span>
									   			    <span class="comment-date"><?php echo $com['c_date']; ?></span>
								   		    	</section>
								   		    	<?php  if($com['user_id']==$session&&$com['item_id']==$itemid){ ?> <i class="fas fa-ellipsis-h dot dotEdit"></i> <?php }else{ ?> <i class="fas fa-ellipsis-h dot dotReport"></i> <?php }  ?>
							   			        <div class="dot-container edit-delete-container">
							   			        	<i class="fas fa-pen" title="<?php echo $lang['Edit'] ?>"></i>
							   			        	<a href="actcom.php?c=<?php echo $com['c_id']?>&i=<?php echo $com['item_id']?>&<?php if($token==1){ echo 't=sg';}elseif($token==2){ echo 't=sv'; }elseif($token==3){ echo 't=ig';}elseif($token==4){ echo 't=iv';}elseif($token==5){ echo 't=p';}elseif($token==6){ echo 't=admin';} ?>"><i class="fas fa-trash confirmDelete" title="<?php echo $lang['del'] ?>"></i><input type="hidden" class="language" value="<?php echo $l;?>"></a>
							   			        </div>
							   			        <div class="dot-container report-container">
							   			        	<?php
							   			        	$fetchComVal=fetch2('value','reportcomm','value',1,'user_id',$session);
							   			        	if($fetchComVal['value']==1){ ?> <i class="fas fa-flag Rflag" title="<?php echo $lang['report'] ?>"></i><?php }
							   			        	else{ ?> <i class="far fa-flag Rflag" title="<?php echo $lang['report'] ?>"></i><?php }
							   			        	?>
							   			            <input type="hidden" class="comid" value="<?php echo $com['c_id']?>">
							   			            <input type="hidden" class="reporter" value="<?php echo $session?>">
							   			            <input type="hidden" class="comOwner" value="<?php echo $$com['user_id']?>">
							   			        </div>
							   			    </div>
							   			</div>
				                        <div class="div-comm-2"><!--  -->
				                        	<form id="inputEditText" class="formEditText" action="details.php?id=<?php echo $itemid.$go?>" method='POST' >
					                            <input type="text" class="newText" name="newText" value="<?php echo $com['c_text']?>" autocomplete='off' >
				                                <input type="hidden" class="comEdit" name="comEdit" value="<?php echo $com['c_id']?>">
				                                <input type="hidden" class="comEdit" name="item" value="<?php echo $com['item_id']?>">
					                            <button class="sendEdit"><?php echo $lang['update'] ?></button>
				                            </form>
				                            <button class="cancel">cancel</button>
				                            <p class="p-comment-homepage" id="p-comment-homepage"><span dir="auto"><?php echo $com['c_text']?></span></p>
				                            <input type="hidden" id="commNum" value="<?php echo $com['c_id']?>">
				                        </div><!--comments on homepage-->
				                  </div>
								 <?php   }  ?> <!-- end foreach -->


								 <!---////////-->
				                       <!--ajax coner -->
								       <script type="text/javascript" src="<?php echo $js; ?>jquery-3.6.0.min.js"></script>
								       <script>
									       $(document).ready(function(){
									       	//thumbs up
								           $(".fa-thumbs-up").on("click", function(){
								          var Comment=$(this).nextAll('.c_id').val();
								          var Item=$(this).nextAll('.item_id').val();
								          var ComOwner=$(this).nextAll('.comOwner').val();
								          var ItemOwner=$(this).nextAll('.itemOwner').val();
								          $.ajax({
								          url:"thumb.php",
								          data:{commentThumb:Comment,item:Item,comOwner:ComOwner,itemOwner:ItemOwner}
								           });
								         });
								           //report  
								           $(".flag").on("click", function(){
								          var C_id=$(this).parent().prevAll('.c_id').val();
								          var Owner=$(this).parent().prevAll('.comOwner').val();
								          var Reporter=$(this).parent().prevAll('.reporter').val();
								          var Item=$(this).parent().prevAll('.item_id').val();
								          $.ajax({
								          url:"thumb.php",
								          data:{c_id:C_id,owner:Owner,reporter:Reporter,item:Item}
								           });
								         });
								           //
								           
								           });
								        </script>
                                    <?php
								//===================start pagination=========================	
										    $jumpForward=1;
										 	$jumpBackward=1;
		 	
										if($NumberOfPages>1 ){ 	?>
										 <nav aria-label="Page navigation example" class="pagination-container">
											  <ul class="pagination pagination-md">
											 <?php if(($pageNum-$jumpBackward)>=1 ){  //previous
											 ?> <li class="page-item"><a class="page-link prev" href="?id=<?php echo $com['item_id']; ?>&page=<?php echo ($pageNum-$jumpBackward)?>"><?php echo $lang['prev'];?></a></li><?php
										      }else{
										      ?> <li class="page-item disabled"><a class="page-link"><?php echo $lang['prev'];?></a></li><?php
										      }
										      //$page=1; $page<= $NumberOfPages;  $page++
										  for ($page=max(1,$pageNum-2);$page<=min($pageNum+2,$NumberOfPages);$page++) {  //for loop
											if (isset($_GET['page'])&&$_GET['page']==$page ) {
												echo   '<li class="page-item"><a class="page-link active" href="details.php?id='.$com['item_id'].'&page='.$page.'">'.$page.'</a></li>';
											}else{
												echo   '<li class="page-item"><a class="page-link" href="details.php?id='.$com['item_id'].'&page='.$page.'">'.$page.'</a></li>';
											} }
										    if(($pageNum+$jumpForward)<=$NumberOfPages){  //next
											?> <li class="page-item"> <a class="page-link next"  href="?id=<?php echo $com['item_id']; ?>&page=<?php echo ($pageNum+$jumpForward)?>"><?php echo $lang['next'];?></a> </li><?php
										}else{
										   ?> <li class="page-item disabled"> <a class="page-link "><?php echo $lang['last'];?></a> </li><?php
										} ?>  
										    </ul > 
										</nav>
										<?php
										}
										////////////// END pagination //////////////
		                     } //END if ($stmt)
                        }  






}else{ //end if (isset($session) ) {
	header('location:login.php');
	exit();
}





include $tmpl."footer.inc";   
ob_end_flush();