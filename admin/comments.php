<?php
ob_start();//to stop problems caused by header
session_start();

if (isset($_SESSION['idMos'])) {	
   $title='Comments';
   include 'init.php';
  $l=$lang['lang']; 

			      $do=isset($_GET['do']) ? $_GET['do'] : 'manage';//short if
			      //stat categories page
			   
			   if ($do=='manage') {
			   	//connect to database
				$stmt=$conn->prepare("SELECT comments.*, items.*,user.*
                FROM comments
                JOIN items ON items.item_id=comments.item_id
                JOIN user ON user.user_id=comments.user_id
                ORDER BY c_id DESC  "); 
                   
				$stmt->execute();
				$fetched=$stmt->fetchAll();
				//End connect to database
				?>
				<h1 class="h1Manage"> Manage Comments</h1>
				<div class="container">
					<div class="table-reponsive">
					<table class="table-manag2">
						<thead>
							<tr>
								<td><a href=""> ID </a> </td>
								<td><a href=""> Commentor </a> </td>
								<td><a href=""> Comment </a> </td>					
								<td><a href=""> Title </a> </td>
								<td><a href=""> Trader </a> </td>
								<td><a href=""> Date </a> </td>
								<td><a href=""> action </a> </td>
						    </tr>
						</thead>
						<tbody>
						<?php
						foreach ($fetched as  $value) {//foreach start
							$fetchItOwner=fetch('user_id','items','item_id',$value['item_id']);
							$fetchItOwnerName=fetch('commercial_name','user','user_id',$fetchItOwner['user_id']);
							echo "<tr class='tr-body'>";
							echo "<td>"                    .$value['c_id']     ."</td>";
							echo "<td><div class='td-div'>".$value['name'] ."</div></td>";
							echo "<td><div class='td-div'>".$value['c_text']        ."</div></td>";
							echo "<td><a href='../details.php?id=".$value['item_id']."&t=s'>".$value['title']."</a></td>";
							echo "<td>".$fetchItOwnerName['commercial_name']."</td>";
							echo "<td><div class='td-div'>".$value['c_date']     ."</div></td>";
							echo "<td class='actionTd'>
							  	      <a href='comments.php?do=edit&id=". $value['c_id']."' class='btn btn-success'> Edit </a> 
								      <a href='comments.php?do=delete&id=". $value['c_id']."' class='btn btn-danger  confirm'>Delete </a>";								     
							   echo  "</td>";//edit, delete & approve  
							echo "</tr>";						
						}//foreach end

						?>
						</tbody>						  										 				
					</table>
					</div>						
				        <a href="dashboard.php" class="btn btn-dark "> Go to Dashboard  </a>
                </div>
			    <?php

                  //////end manage page////
			      //////start edit page////

			   }elseif($do=='edit'){
			   	// this is edit page
						 //check $_GET request and store it
						 $CID=isset($_GET['id']) && is_numeric($_GET['id'])?intval($_GET['id']):0; 
						 //Bring user data from database
						 $stmt=$conn->prepare("SELECT * FROM comments  
                          JOIN items ON items.item_id=comments.item_id
                          JOIN user ON user.user_id=comments.user_id
						  WHERE comments.c_id=?	");
						 $stmt->execute(array($CID));
						 $fetched=$stmt->fetch();
						 $count=$stmt->rowCount();
                         
                         //echo $fetched['group_id'];
						   if ($count>0){ ?>
									    <form class="form-edit" action="?do=update" method="POST">
									    	<h1 class="h1-style">  Edit comments </h1>
									    	<input type="hidden" name="c_id" value="<?php echo $CID ?>">
								 
							  	        <label for="inputEmail3" class="col-sm-2 col-form-label">Comment</label>
								        <div class="div-input-container">
								        <textarea dir="auto" class="textarea-comment" id="inputEmail3"  name="newC_text" value="<?php echo $fetched['c_text']?>" placeholder="<?php echo $fetched['c_text']?>" ></textarea>
								        <input type="text" class="fetched-text"  value="<?php echo $fetched['c_text']?>" >
								        <input type="hidden"  name="oldC_text" value="<?php echo $fetched['c_text']?>" >
								        <span class="span-required span-required-des"> * </span>							            
							            </div>


							            <label for="inputEmail3" class="col-sm-2 col-form-label">Date</label>
								        <div class="div-input-container  ">
								        <input type="text" class="  input-add-page" id="inputEmail3" value="<?php echo $fetched['c_date']?>" readonly>   
							            </div>
					                			        


							            <label for="inputEmail3" class="col-sm-2 col-form-label">User</label>				        
					                    <div class="div-input-container  ">
								        <input type="text" class="  input-add-page" id="inputEmail3" name="user" 
								        value="<?php echo $fetched['name']?>" readonly>					            
							            </div>


							            <label for="inputEmail3" class="col-sm-2 col-form-label">Item</label>				        
					                    <div class="div-input-container  ">
								         <input type="text" class="  input-add-page" id="inputEmail3" name="user" 
								          value="<?php echo $fetched['title']?>" readonly>	
							            </div>
								        
									    <input type="submit" name="submit" value="Edit Comment">	
					                </form>
								    <?php
							}else{
								$redirectHomeMsg="You aren't allowed here";
							    redirectHome($redirectHomeMsg);
							}

					    //end edit page
					    //start update page
			   }elseif($do=='update'){
			      if($_SERVER['REQUEST_METHOD']=='POST')  {
						echo "<h1 class='h1-style'> Update Comment </h1>";
					    // recall database to store data, then store in variables
						 $c_text1     =!empty($_POST['newC_text'])?trim($_POST['newC_text']):$_POST['oldC_text'];
						$CID        =$_POST['c_id'];

						$c_text=filter_var($c_text1,FILTER_SANITIZE_STRING);							
						 //connecting with database to send new data
						 $stmt=$conn->prepare('UPDATE  comments  SET  c_text=? WHERE  c_id=? ');
				         $stmt->execute(array($c_text,$CID));
						 $count=$stmt->rowCount();
				         //success
						 echo '<h5>   success </h5>';
						 echo "<div class='alert alert-success'>" . $count . " Comment updated  </div>";															 								 									
                         echo "<div class='center'><a href='comments.php'> Comments </a>&emsp;&emsp;&emsp; <a href='dashboard.php'> Dashboard </a></div>";	                                                        
						}else{
					     $redirectHomeMsg="You aren't allowed here";
						redirectHome($redirectHomeMsg);
						}
			            echo   '</div>';

                ////////end update page///////////
	            ///////start delete page/////////
			   }elseif($do=='delete'){
			   	       echo "<div class='container'> ";
						echo '<h1 class="h1ManagePages"> Delete Comment   </h1>';
						$CID=isset($_GET['id']) && is_numeric($_GET['id'])?intval($_GET['id']):0;				   
 
						  // call back data from database through the function "checkItem" to examine the condition 
				        $check=checkItem('c_id', 'comments', $CID);
						 //if condition is ok, call back data from database AGAIN to carry out deletion                       
				        if ($check>0) {  
						         $stmt=$conn->prepare('DELETE  FROM  comments  WHERE  c_id = :zid ');
						         $stmt->bindParam(':zid', $CID);
								 $stmt->execute();
								 $stmt->rowCount();

								 echo '<h5>   success </h5>';							    
							     echo "<div class='alert alert-success'>".$stmt->rowCount(). " Comment deleted </div>";     
							     echo "<div class='center'><a href='comments.php'> Comments </a>&emsp;&emsp;&emsp; <a href='dashboard.php'> Dashboard </a></div>";	                                                      

			        	}else{
		        		
		        		$redirectHomeMsg='This member isn\'t exisiing';	
		        		redirectHome($redirectHomeMsg);			        		 			                				        		 
			        	}

					        	echo '</div>';

               /////// End delete page     /////////
              /////////start approve page/////////

			   }elseif ($do=='deleteRow') {
			      $CID=isset($_GET['id']) && is_numeric($_GET['id'])?intval($_GET['id']):0;				   
 
						  // call back data from database through the function "checkItem" to examine the condition 
				        $check=checkItem('comment_id', 'reportcomm', $CID);
						 //if condition is ok, call back data from database AGAIN to carry out deletion                       
				        if ($check>0) {  
						         $stmt=$conn->prepare('DELETE  FROM  reportcomm  WHERE  comment_id =? ');
								 $stmt->execute(array($CID));
								 $stmt->rowCount();

								 echo '<h5>   success </h5>';							    
							     echo "<div class='alert alert-success'>".$stmt->rowCount(). " Row removed </div>";     
							     echo "<div class='center'><a href='comments.php'> Comments </a>&emsp;&emsp;&emsp; <a href='dashboard.php'> Dashboard </a></div>";	                                                      

			        	}else{
		        		
		        		$redirectHomeMsg='This member isn\'t exisiing';	
		        		redirectHome($redirectHomeMsg);			        		 			                				        		 
			        	}
			  

			    }elseif($do=='approve'){
			   	         echo "<div class='container'> ";
						 echo '<h1 class="h1ManagePages"> Approve Comment   </h1>';

						 $CID=isset($_GET["id"]) && is_numeric($_GET["id"])?intval($_GET["id"]):0; 
												 
						  // call back data from database through the function "checkItem" to examine the condition 
				          $check=checkItem("c_id", "comments", $CID);
				         
						 //if condition is ok, call back data from database AGAIN to carry out deletion                       
				         if ($check>0){  
						         $stmt=$conn->prepare('UPDATE  comments  SET  c_status=1  WHERE  c_id =? ');
								 $stmt->execute(array($CID));
								 $stmt->rowCount();

								 echo '<h5>   success </h5>';						    
							     echo "<div class='alert alert-success'>".$stmt->rowCount(). " Comment approved </div>";
							     echo "<a href='comments.php'> Back </a>";     
							     

			        	 }else{		        		
		        		 $redirectHomeMsg='This member isn\'t exisiing';	
		        		 redirectHome($redirectHomeMsg);			        		 			                				        		 
			        	 }

					        	echo '</div>';

			}/////////end activate page
			                      

				   


			   








   include  $tmpl ."footer.inc";

}else{
	header('location:index.php');
	exit();
}
ob_end_flush();
?>