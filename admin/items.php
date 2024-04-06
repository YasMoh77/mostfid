<?php
ob_start();//to stop problems caused by header
session_start();
$title='items';
include 'init.php';

if (isset($_SESSION['idMos'])) {	
            $l=$lang['lang'];  
			$do=isset($_GET['do']) ? $_GET['do'] : 'manage';//short if
				   if ($do=='manage') { //manage items 
				  $stmt=$conn->prepare(" SELECT count(item_id) FROM items
	            INNER JOIN categories ON categories.cat_id=items.cat_id
	            INNER JOIN sub ON sub.subcat_id=items.subcat_id
	            INNER JOIN user ON user.user_id=items.user_id
	            INNER JOIN country ON country.country_id=items.country_id
	            INNER JOIN state ON state.state_id=items.state_id
	            INNER JOIN city ON city.city_id=items.city_id
	            where country.country_id>0 ORDER BY items.item_id DESC ");
	          $stmt->execute(); 
	          $itemsNum=$stmt->fetchColumn();

	          //pagination data
	          $adsPerPage=10; 
	          $NumberOfPages=ceil($itemsNum/$adsPerPage);
	          $pageNum= isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page']<=$NumberOfPages&& $_GET['page']>0 ? intval($_GET['page']) : 1; 
	          $startFrom=($pageNum-1)* $adsPerPage; //

				//connect to database
				$stmt=$conn->prepare("SELECT items.*,categories.*,sub.*,country.*,state.*,city.*,user.*
                    FROM items
                    INNER JOIN categories ON categories.cat_id=items.cat_id
                    INNER JOIN sub ON sub.subcat_id=items.subcat_id
                    INNER JOIN user ON user.user_id=items.user_id
                    INNER JOIN country ON country.country_id=items.country_id
                    INNER JOIN state ON state.state_id=items.state_id
                    INNER JOIN city ON city.city_id=items.city_id
                    where country.country_id>0 ORDER BY items.item_id DESC limit $startFrom, $adsPerPage ");
				$stmt->execute();
				$fetched=$stmt->fetchAll();
				//End connect to database
				?>
				<p>Credit is marked red & Hide=hidden if credit < max(item_mostafed)
				<br><span class="back-yel">Yellow</span>=Highest value for item_mostafed among items of this trader
				<br><span class="back-red">Red</span>=credit is less than highest value in item_mostafed so items are hidden & trader needs charging 

				</p>
				<h1 class="h1Manage"> Manage items</h1>
				<div class="container">
					<div class="table-reponsive table-items">
					<table class="table-manage tableItems">
						<thead>
							<tr> 
								<td><a href=""> ID </a> </td>
								<td><a href=""> Photo </a> </td>
								<td><a href=""> Item Name </a> </td>
								<td><a href=""> Description </a> </td>
								<td><a href=""> Price </a> </td>
								<td><a href=""> Discount </a> </td>
								<td><a href=""> Item Mostafed </a> </td>
								<td><a href=""> Credit </a> </td>
								<td><a href=""> Country-St-City </a> </td>
								<td><a href=""> Approve <br>✓=approved </a> </td>
								 <td><a href=""> Hide <br>✓=shown </a> </td>
								<td><a href=""> Category Name </a> </td>
								<td><a href=""> Username </a> </td>								
								<td><a href=""> Registry date </a> </td>
								<!--<td><a href=""> Expiry date </a> </td>-->
								<td><a href=""> Item views </a> </td>
								<td><a href=""> action </a> </td>
						    </tr>
						</thead>
						<tbody>
						<?php 

						foreach ($fetched as  $value) {//foreach start
							//get max value for item mostafed to check if trader has enough credit for paying online
							$stmt=$conn->prepare("SELECT max(item_mostafed),user.online_pay FROM  items
							  join user on  items.user_id=user.user_id WHERE user.user_id=? and user.online_pay=1 ");
							$stmt->execute(array($value['user_id']));
							$fetchMax=$stmt->fetch();
							//get trader field
						    $field=fetch('cat_id','user','user_id',$value['user_id']);

							echo "<tr class='tr-body'>";
							echo "<td>"                    .$value['item_id']     ."</td>";
							echo "<td><div class='td-div'><img src='../data/upload/".$value['photo']."'> </div></td>";
							echo "<td><div class='td-div'><a href='../details.php?id=".$value['item_id']."&t=admin&main=admin&source=c'>".$value['title']        ."</a></div></td>"; 
							echo "<td><div class='td-div'>".$value['description'] ."</div></td>";
							echo "<td>"                    .$value['price']       ."</td>";
							echo "<td>"                    .$value['discount'].'%'."</td>";
							echo "<td>"; if($value['item_mostafed']==$fetchMax['max(item_mostafed)']){ echo '<span class="back-yel">'.$value['item_mostafed'].'</span>';}else{ echo $value['item_mostafed']; } echo "</td>";
							echo "<td>"; if($field['cat_id']>=7&&$field['cat_id']<=9){ if($value['credit']<$fetchMax['max(item_mostafed)']){ echo '<span class="red">'.$value['credit'].'</span>'; }else{ echo $value['credit'];} }else{ if($value['credit']<$fetchMax['max(item_mostafed)']*3) { echo '<span class="red">'.$value['credit'].'</span>'; }else{ echo $value['credit']; } }  echo "</td>";
							echo "<td><div class='td-div long'>".$value['country_nameAR'].'-'.$value['state_nameAR'].'-'.$value['city_nameAR']."</div></td>";
							//status
							echo "<td><div class='td-div2'>"; if($value['approve']==0){echo'<span class="red">Pending</span>';}else{echo'<i class="fas fa-check green"></i>';} echo "</div></td>";
							echo "<td><div class='td-div2'>"; if($value['hide']==0){echo'<i class="fas fa-check green"></i>';}else{echo'<span class="red">hidden</span>';} echo "</div></td>";
							echo "<td><div class='td-div long'>".$value['cat_nameAR'].'-'.$value['subcat_nameAR']."</div></td>";
							echo "<td class='td-username'><div class='td-div'>".$value['commercial_name']      ."</div></td>";
							echo "<td><div class='td-div3'>".$value['item_date']. "</div></td>";	
							//echo "<td><div class='td-div'>".$value['expiry_date'].'<br>'; if($value['CAT_ID']>3 && $_SESSION['idMos']==7){echo "<a href='items.php?do=renew&i=".$value['item_id']."'>RENEW </a>";}; echo "</div></td>";					
							echo "<td><div class='td-div'>".$value['seen']. "</div></td>"; // item views
							
							echo ""; // End item views
							echo "<td class='actionTd'>";
							echo   "<a class='view-link' title='view' href='../details.php?id=". $value['item_id']."&t=admin&main=admin&source=c'><i class='fas fa-eye'></i> </a>"; 
							if($_SESSION['idMos']==7){
							echo   "<a href='items.php?do=edit&id=". $value['item_id']."' class='btn btn-success'> Edit </a>"; 
							echo   "<a href='items.php?do=delete&id=". $value['item_id']."' class='btn btn-danger  confirm'>Delete </a>";
							     }
							    
							      if($value['approve']==0){ 
							        echo"<a href='items.php?do=approve&id=".$value['item_id']."' class='btn btn-info   confirmActivate'>Approve</a>";		     								      
						          }elseif($value['approve']==2){echo"<a title='activate edited' href='items.php?do=approve&id=". $value['item_id']."' class='btn btn-info   confirmActivate'>Edited</a>";}
							   echo  "</td>";//edit, delete & approve </div> 
							echo "</tr>";						
						}//foreach end

						?>
						</tbody>						  										 				
					</table>
					</div>	<?php

					//===================start pagination=========================  
			        $jumpForward=1;
			        $jumpBackward=1; 

			      if($NumberOfPages>1 ){  ?>
			       <nav aria-label="Page navigation example" class="pagination-container">
			          <ul class="pagination pagination-md">
			         <?php if(($pageNum-$jumpBackward)>=1 ){  //previous
			         ?> <li class="page-item"><a class="page-link prev" href="?page= <?php echo ($pageNum-$jumpBackward)?> "><<</a></li><?php
			            }else{
			            ?> <li class="page-item disabled"><a class="page-link"><<</a></li><?php //disabled previous
			            }
			            if($pageNum>1){ ?><li class="page-item"><a class="page-link" href="items.php?page=1">First  </a></li><?php }
			            	elseif($pageNum==1){ ?><li class="page-item"><a class="page-link active" href="items.php?page=1">1</a></li><?php }

			            //$page=1; $page<= $NumberOfPages;  $page++
			        for ($page=max(2,$pageNum-2);$page<min($pageNum+2,$NumberOfPages);$page++) {  //for loop
			        if (isset($_GET['page'])&&$_GET['page']==$page ) {
			          echo   '<li class="page-item"><a class="page-link active" href="items.php?page='.$page.'">'.$page.'</a></li>';
			        }elseif (!isset($_GET['page'])&&$page==1 ) {
			           echo   '<li class="page-item"><a class="page-link active" href="items.php?page='.$page.'">'.$page.'</a></li>';
			        
			        }else{
			          echo   '<li class="page-item"><a class="page-link" href="items.php?page='.$page.'">'.$page.'</a></li>';
			        } }

			        if($NumberOfPages-$pageNum>=1){ ?><li class="page-item"><a class="page-link" href="items.php?page=<?php echo $NumberOfPages; ?>">Last </a></li><?php }
			          if(($pageNum+$jumpForward)<=$NumberOfPages){  //next
			        ?> <li class="page-item"> <a class="page-link next"  href="?page=<?php echo ($pageNum+$jumpForward) ?>">>></a> </li><?php
			      }else{
			         ?> <li class="page-item disabled"> <a class="page-link ">>></a> </li><?php
			      } ?>  
			          </ul > 
			      </nav>
			      <?php
			      } 
			      ////////////// END pagination ////////////// 					
				     ?>   <a href="items.php?do=add" class="btn btn-primary "> Add new item  </a>                      
                </div>

			    <?php 
                  //////end manage page////
			      //////start add page////
				   }elseif ($do=='acceptplan') {
				    
				   	//END ELSEIF($do=='rejectplan')
				   }elseif ($do=='rejectplan') {
				     
				   	//END ELSEIF($do=='acceptplan')
				   }elseif ($do=='changePlan') {
				   	
				   

				   }elseif($do=='add'){

						   	// this is add page				   	      
		                    ?>                  
						    <form class="form-edit" action="?do=insert" method="POST" enctype="multipart/form-data">
						    	<h1 class="h1-style">  Add new item </h1>
					 
				  	        <label for="inputEmail3" class="col-sm-2 col-form-label">Item Name</label>
					        <div class="div-input-container  "> 
					        <input type="text"   class="input-add-page" id="inputEmail3" name="name"  placeholder=" between 8 - 60 characters" required>
				            <span class="span-required"> * </span>
				            </div>
		                			        

						    <label for="inputEmail3" class="col-sm-2 col-form-label">Description</label>				  
		                    <div class="div-input-container  ">
					        <input  class=" inputPassword  input-add-page" id="inputEmail3" 
					        name='desc' placeholder=" between 20 - 2000 characters"
					         maxlength="4000" required>
				            <span class="span-required"> * </span>
				            </div>  
		                     

						    <label for="inputEmail3" class="col-sm-2 col-form-label">Price</label>				        
		                    <div class="div-input-container  ">
					        <input type="text" class=" inputPassword  input-add-page" id="inputEmail3" 
					        name='price' placeholder=" Add price " >
				            <span class="span-required"> * </span> 
				            </div>

				            <label for="inputEmail3" class="col-sm-2 col-form-label">Discount</label>				        
		                    <div class="div-input-container  ">
					        <input type="text" class=" inputPassword  input-add-page" id="inputEmail3" 
					        name='discount' placeholder=" Discount " >
					        &emsp;<i title="مشاهدة نسب الخصم" class="fas fa-exclamation-triangle" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMsg" aria-controls="offcanvasMsg"></i>
				            <span class="span-required"> * </span>
				            </div>



	                        <!-- canvas discount -->
	                        <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasMsg" aria-labelledby="offcanvasWithBothOptionsLabel">
	                            <div class="offcanvas-header offcanvas-header-msg">
	                               <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
	                                <span class=" msg-to cut2">نسبة الخصم بناء على السعر:</span>
	                            </div>
	                              <div class="offcanvas-body-msg">
	                                <ul>
	                                  <li>السعر حتى 100 جنية مصري .. الخصم لا يقل عن 15%</li>
	                                  <li>السعر من 101 جنية مصري حتى 400  جنية مصري .. الخصم لا يقل عن 10%</li>
	                                  <li>السعر من 401 جنية مصري حتى  1000 جنية مصري .. الخصم لا يقل عن 8%</li>
	                                  <li>السعر من 1001 جنية مصري حتى 10000 (عشرة آلاف).. الخصم لا يقل عن 5%</li>
	                                  <li>السعر من 10001 جنية مصري حتى 40000 (أربعون ألف).. الخصم لا يقل عن 4%</li>
	                                  <li>السعر من 40001 جنية مصري فما فوق .. الخصم لا يقل عن 3%</li>
	                                </ul>
	                              </div>
	                          </div>




				            <label for="inputEmail3" class="col-sm-2 col-form-label">Country</label>				   
		                    <div class="div-input-container  ">
				            <select class=" inputPassword  input-add-page" id="country" name='country' required>
				            	<option>choose</option>
				            	<?php
							        //connect to db to fetch fields
								   	$stmt=$conn->prepare(" SELECT * FROM country where country_id=1");
								   	$stmt->execute();
								   	$fetched=$stmt->fetchAll();
									foreach ($fetched as  $con) {
									echo "<option class='option-parent' value='".$con['country_id']."'>".$con['country_nameAR']. "</option>";
									}	        	
							    ?>				
				            </select>
				            <span class="span-required"> * </span>
				            </div>

				            <label for="inputEmail3" class="col-sm-2 col-form-label">State</label>				   
		                    <div class="div-input-container  ">
				            <select class=" inputPassword  input-add-page" id="state" name='state' required >
				            	<option>choose</option>
				            </select>
				            <span class="span-required"> * </span>
				            </div>


				            <label for="inputEmail3" class="col-sm-2 col-form-label">City</label>				   
		                    <div class="div-input-container  ">
				            <select class=" inputPassword  input-add-page" id="city" name='city' required>
				            	<option>choose</option>
				            </select>
				            <span class="span-required"> * </span>
				            </div>



				           <label for="inputEmail3" class="col-sm-2 col-form-label">Category </label>				      
		                    <div class="div-input-container  ">
					        <select class=" inputPassword  input-add-page  Cat" id="subcat"  name='cat' required>
					        	<option value="0">choose</option>
							        <?php
							        //connect to db to fetch fields
								   	$stmt=$conn->prepare(" SELECT * FROM categories ");
								   	$stmt->execute();
								   	$fetched=$stmt->fetchAll();
									foreach ($fetched as  $catf) {
									echo "<option class='option-parent' value='".$catf['cat_id']."'>".$catf['cat_nameAR']. "</option>";
									}	        	
							        ?>					        	
					        </select>
				            <span class="span-required"> * </span>
				            </div>	

				            <label for="inputEmail3" class="col-sm-2 col-form-label">Sub-category 2</label>				      
		                    <div class="div-input-container  ">
					        <select class=" inputPassword  input-add-page  sub" id="subcat2"  name='sub' required>
					        	<option value="0">choose</option>
							        <?php
							        //connect to db to fetch fields
								 	$stmt=$conn->prepare(" SELECT  * FROM sub  ");
								   	$stmt->execute();
								   	$subs=$stmt->fetchAll();
									foreach ($subs as  $sub) {
									echo "<option class='option-parent' value='".$sub['subcat_id']."'>".$sub['subcat_nameAR']. "</option>";
									}       	
							        ?>					        	
					        </select>
				            <span class="span-required"> * </span>
				            </div>



                              <!--contact-->
                            <label for="inputEmail3" class="col-sm-2 col-form-label-file">Phone</label>               
                            <div class="div-input-container">
	                           <div class="div-input-container2  ">
	                               <!--phone-->
	                               <i class="fas fa-phone-volume"></i>
	                              <select class=" inputPassword  input-add-page" id="phone"  name='phone' required>
					        	    <option value="0">choose</option>
							        	<?php
							        	$stmt=$conn->prepare(" SELECT commercial_name,phone FROM user where trader=1 and password is not null ");
							        	$stmt->execute();
							        	$fetchedPh=$stmt->fetchAll();
							        	foreach ($fetchedPh as  $value) {
							        	echo '<option value="' .$value['phone'].'">' .$value['phone'].' => '.$value['commercial_name'].'</option>';
							        	} ?>
					              </select>
	                            </div>
                            </div>



				            <label for="inputEmail3" class="col-sm-2 col-form-label">Members</label>				    
		                    <div class="div-input-container  ">
					        <select class=" inputPassword  input-add-page" id="inputEmail3"  name='members' required>
					        	<option value="0">choose</option>
							        	<?php
							        	$stmt=$conn->prepare(" SELECT commercial_name,user_id FROM user where trader=1 and password is not null ");
							        	$stmt->execute();
							        	$fetched=$stmt->fetchAll();
							        	foreach ($fetched as  $value) {
							        	echo '<option value="' .$value['user_id'].'">' .$value['commercial_name'].'</option>';
							        	} ?>
					        </select>
				            <span class="span-required"> * </span>
				            </div>

				            <label for="inputEmail3" class="col-sm-2 col-form-label">Upload photo</label>				        
		                    <div class="div-input-container  ">
					        <input type="file" class="inputPassword"  id="inputEmail3"  name='photo'  required>
					          <br><br><br><br>
				            <span class="span-required"> * </span>
				            </div>


	                        
					        <!--delivery -->
	                        <label for="inputEmail3" class="col-sm-2 col-form-label lbl-price">Delivery</label>                
	                        <span class="red small"> * </span>
	                        <div class="div-input-container  div-price ">
	                            <div>
	                              <input type="checkbox" name="delivery1" id="delivery1" class="delivery" value="1">
	                              <label for='delivery1'>التوصيل داخل المحافظة بمقابل</label>
	                            </div>
	                            <div>
	                              <input type="checkbox" name="delivery2" id="delivery2" class="delivery" value="2"> 
	                              <label for='delivery2'>التوصيل داخل المحافظة مجانا </label>
	                            </div>
	                            <div>
	                              <input type="checkbox" name="delivery3" id="delivery3" class="delivery" value="3">
	                              <label for='delivery3'>التوصيل داخل المدينة بمقابل </label>
	                            </div>
	                            <div>
	                              <input type="checkbox" name="delivery4" id="delivery4" class="delivery" value="4">
	                              <label for='delivery4'>التوصيل داخل المدينة مجانا </label>
	                            </div>
	                            <div>
	                              <input type="checkbox" name="delivery5" id="delivery5" class="delivery" value="5">
	                              <label for='delivery5'>التوصيل لجميع المحافظات بمقابل  </label>
	                            </div>
	                            <div>
	                              <input type="checkbox" name="delivery6" id="delivery6" class="delivery" value="6">
	                              <label for='delivery6'>التوصيل لجميع المحافظات  مجانا </label>
	                            </div>
	                            <div>
	                              <input type="checkbox" name="delivery7" id="delivery7" class="delivery" value="7">
	                              <label for='delivery7'>لا يوجد توصيل</label>
	                            </div>
	                        </div> 


	            
					        <div class="last-div">
					        <span class="span-required2">(*) = required</span>
		                    </div>
						    <input type="submit" name="submit" value="Add Item">
                            
		                </form>
		                <input type="hidden" id="lng" value="ar">

		                 <!--ajax coner -->
                      <script type="text/javascript" src="<?php echo $js; ?>jquery-3.6.0.min.js"></script>
                      <script>
                      $(document).ready(function(){
                        //ajax call country to return states
                        $("#country").on("change", function(){
                          var country=$(this).val();
                          var l=$('#lng').val();
                          $.ajax({
                          url:"../catSelect.php",
                          data:{sentCountry:country,l:l},
                          success: function(data){                             
                            $("#state").html(data);
                             }
                           });
                        });
                        //ajax call state
                        $("#state,#country").on("change", function(){
                          var state=$(this).val();
                          var l=$('#lng').val();
                          $.ajax({
                          url:"../catSelect.php",
                          data:{sentState:state,l:l},
                          success: function(data){                             
                            $("#city").html(data);
                             }
                           });
                        });
                        //ajax call subcats 
                       $("#subcat").on("change", function(){
                       var cats=$(this).val();
                       var L=$('#lng').val();
                       $.ajax({
                       url:"../showSubCats.php",
                       data:{sentCats:cats,l:L},
                       success: function(data){                             
                        $('#subcat2').html(data);
                         }
                        });
                      });
                      //




                        });
                    </script>
					    <?php



                 }elseif($do=='insert'){
						   	//insert Item page
							if($_SERVER['REQUEST_METHOD']=='POST')  {
							echo "<div class='container'> ";	
							echo "<h1 class='text-center  h1ManagePages' > Insert Item </h1>";
                             
						    //store data in variables
							$name     =filter_var(trim($_POST['name']),FILTER_SANITIZE_STRING);
							$desc     =filter_var(trim($_POST['desc']),FILTER_SANITIZE_STRING);
							$pri      =filter_var(trim($_POST['price']),FILTER_SANITIZE_NUMBER_INT);
							$contr    =$_POST['country'];
							$st       =$_POST['state'];
							$city     =$_POST['city'];
							$cat      =$_POST['cat'];
							$sub      =$_POST['sub'];
							$mem      =$_POST['members'];
							//contact
							$phone      =filter_var(trim('0'.$_POST['phone']),FILTER_SANITIZE_NUMBER_INT);
							$discount   =filter_var(trim($_POST['discount']),FILTER_SANITIZE_NUMBER_INT);
							date_default_timezone_set("Africa/Cairo");
							$date       =date('Y-m-d',time());
                            
                            if (isset($_POST['delivery1'])) {
                            	$delivery=$_POST['delivery1'];
                            }elseif (isset($_POST['delivery2'])) {
                            	$delivery=$_POST['delivery2'];
                            }elseif (isset($_POST['delivery3'])) {
                            	$delivery=$_POST['delivery3'];
                            }elseif (isset($_POST['delivery4'])) {
                            	$delivery=$_POST['delivery4'];
                            }elseif (isset($_POST['delivery5'])) {
                            	$delivery=$_POST['delivery5'];
                            }elseif (isset($_POST['delivery6'])) {
                            	$delivery=$_POST['delivery6'];
                            }elseif (isset($_POST['delivery7'])) {
                            	$delivery=$_POST['delivery7'];
                            }else{
                            	 $delivery=0;
                            }

							

							//file
							$photoName=$_FILES['photo']['name'];
                            $photoSize=$_FILES['photo']['size'];
                            $photoTmp=$_FILES['photo']['tmp_name']; 
							$photoType=$_FILES['photo']['type'];

							//refine file upload
                            $expl=explode(".", $photoName);
							$refinedPhotoName=strtolower(end($expl));
                            $allowedExtensions=array('jpg','jpeg','png');
                             
		             		/////if fields are left out empty////////////
			                     $error= array( );
								if (empty($name)) {
									$error[]="<div class='alert alert-danger'>Sorry! This field \"Item Name\"  is missing </div>";					 
								}
								if (strlen($name)<8) {
									$error[]="<div class='alert alert-danger'>This field \"name\" is too short </div>";
								 } 
								 if (strlen($name)>60) {
									$error[]="<div class='alert alert-danger'>This field \"name\" is too long </div>";
								 }  
			                     if (empty($desc)) {
									$error[]="<div class='alert alert-danger'>Sorry! This field \"Description\"  is missing</div>";					 
								}
								 if (strlen($desc)<20) {
									$error[]="<div class='alert alert-danger'>This field \"Description\" is too short </div>";
								 } 
								 if (strlen($desc)>2000) {
									$error[]="<div class='alert alert-danger'>This field \"Description\" is too long </div>";
								 }  
 


			                    if (empty($pri)) {
									$error[]="<div class='alert alert-danger'>Sorry! This field \"Price\"  is missing</div>";			 
								}
								if (empty($phone)) {
									$error[]="<div class='alert alert-danger'>Sorry! This field \"phone\"  is missing</div>";			 
								}
								if (empty($discount)) {
									$error[]="<div class='alert alert-danger'>Sorry! This field \"discount\"  is missing</div>";			 
								}
		                        if ($contr==0) {
									$error[]="<div class='alert alert-danger'>Sorry! You didn't choose a value in the field \"country\"</div>";			 
								}
								if ($st==0) {
									$error[]="<div class='alert alert-danger'>Sorry! You didn't choose a value in the field \"State\"</div>";			 
								}
								if ($city==0) {
									$error[]="<div class='alert alert-danger'>Sorry! You didn't choose a value in the field \"city\"</div>";			 
								}
								if ($cat==0) {
									$error[]="<div class='alert alert-danger'>Sorry! You didn't choose a value in the field \"Category\"</div>";			 
								}
								if ($sub==0) {
									$error[]="<div class='alert alert-danger'>Sorry! You didn't choose a value in the field \"sub-category\"</div>";			 
								}
								if ($mem==0) {
									$error[]="<div class='alert alert-danger'>Sorry! You didn't choose a value in the field \"Members\" </div>";			 
								}
								if ($delivery==0) {
									$error[]="<div class='alert alert-danger'>Sorry! You didn't choose a value in the field \"delivery\" </div>";			 
								}elseif ($cat==7&&$delivery>0&&$delivery<7) {
									$error[]="<div class='alert alert-danger'>Sorry! Choose no delivery for this category </div>";			 
								}
								if (empty($refinedPhotoName)) {
									$error[]="<div class='alert alert-danger'>Sorry! You didn't upload a photo </div>";			 
								}
								if (!empty($refinedPhotoName) && !in_array($refinedPhotoName,$allowedExtensions)) {
									$error[]="<div class='alert alert-danger'>Sorry! only 'jpg,jpeg and png' extensions are allowed </div>";			 
								}
			                    if (($photoSize)>4096000) {
									$error[]="<div class='alert alert-danger'>Sorry! allowed image size mustn't exceed 4 MB </div>";			 
								}
								if ( isset($photoSize) && $photoSize>0 && $photoSize<1000  ) { 
							        $error[]="<div class='alert alert-danger'>".$lang['mainPicSmall']."</div>";       
							    }
						        
			                    
			                     if (empty($error)) {   //if there is no error
	                                 $finalName=rand(0,1000000).'_'.$refinedPhotoName;
	                                 move_uploaded_file($photoTmp, "..\data\upload\\".$finalName);
			                  	 //connecting with database to send new data
							     $stmt=$conn->prepare("INSERT INTO  
								 	  items(title,description,price,discount,country_id,state_id,city_id,cat_id,subcat_id,delivery,user_id,item_date,
								 	  phone,photo  )
								    VALUES (:zname,:zdesc,:zprice,:zdisc,:zcountry,:zstate,:zcity,:zcat,:zsub,:zdeliv,:zmem,:zdate,
								    :zphone,:zphoto )");
						         $stmt->execute(array(
									   "zname"    =>   $name,
									   "zdesc"    =>   $desc,
									   "zprice"   =>   $pri,
									   "zdisc"    =>   $discount,
								       "zcountry" =>   $contr,
								       "zstate"   =>   $st,
								       "zcity"    =>   $city,
								       "zcat"     =>   $cat,
								       "zsub"     =>   $sub,
								       "zdeliv"   =>   $delivery,
								       "zmem"     =>   $mem,
								       "zdate"    =>   $date,
								       "zphone"    =>   $phone,
								       "zphoto"   =>   $finalName,
						                ));

									  $stmt->rowCount();
							          //success
									  echo '<h5>   success </h5>';		  
									  echo "<div class='alert alert-success'>".$stmt->rowCount(). " Item inserted </div>";													
									  echo "<a href='items.php'> Go to items page </a>";
										
										}else{
											//
											foreach ($error as  $value1) {
			                                  echo $value1  ;
					                         } 
					                     echo "<a href='items.php?do=add'> Back </a>";
										}	
			                                      
					
						}else{				    
						$redirectHomeMsg="You aren't allowed here";
						redirectHome($redirectHomeMsg);
						}
			           
			            echo   '</div>';

		          ///////End insert page//////////////////
			     ///////start edit page//////////////////
				   }elseif($do=='edit'){
					     // this is edit page
						 $ITEMID=isset($_GET['id']) && is_numeric($_GET['id'])&&$_GET['id']>0?intval($_GET['id']):0; 
								 $stmt=$conn->prepare("SELECT * FROM items 
								 	JOIN categories on items.cat_id=categories.cat_id
								 	JOIN sub on items.subcat_id=sub.subcat_id
								 	WHERE items.item_id=? ");
								 $stmt->execute(array($ITEMID));
								 $fetched=$stmt->fetch();
								 $count=$stmt->rowCount();
						   if ($count>0){ ?>
					                                      
									    <form class="form-edit editItem" action="?do=update" method="POST" enctype="multipart/form-data">
									    	<h1 class="h1-style">  Edit item </h1>
									    	<input type="hidden" name="item_id" value="<?php echo $ITEMID?>">

									   	<!-- name -->
							  	        <label for="inputEmail3" class="col-sm-2 col-form-label">Item Name</label>
								        <div class="div-input-container  "> 
								        <input type="text" class="  input-add-page" id="inputEmail3" name="name" value="<?php echo $fetched['title']?>" minlength='8' maxlength='60'>
								        <input type="text" class="fetched-text"   value="<?php echo $fetched['title']?>" >
								        <input type="hidden" name="oldName" value="<?php echo $fetched['title']?>">
								        
							            <span class="span-required"> * </span>
							            <span>  8 - 60 characters </span>
							            </div>
					                			        
                                         <!-- description -->
									    <label for="inputEmail3" class="col-sm-2 col-form-label">Description</label>				        
					                    <div class="div-input-container  ">
					                    <textarea class=" inputPassword   textarea-comment" id="inputEmail3" 
								        name='description' placeholder="<?php echo $fetched['description']?>" minlength='20' maxlength='2000' ></textarea> 
								        <input type="text" class="fetched-text" name="description" value="<?php echo $fetched['description']?>" >
								        <input type="hidden" name="oldDescription" value="<?php echo $fetched['description']?>" >
								        
							            <span class="span-required span-required-des"> * </span>
							            <span> 20 - 2000 characters </span>
							            </div>


					                     <!-- price -->
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Discounted Price</label>				        
					                    <div class="div-input-container  ">
								        <input type="text" class=" inputPassword  input-add-page" id="inputEmail3" 
								        name='price' placeholder=" Add price " value="<?php echo $fetched['price']?>"  readonly>
							            <span class="span-required"> * </span>
							            <span><?php echo $fetched['price']?></span>
							            </div>
                                      

									    <!-- Categories -->
							            <label for="inputEmail3" class="col-sm-2 col-form-label">Categories</label>				        
					                    <br>
					                    <div class="div-input-container  ">
								        <select name="categories1" id="subcat">
		                             	<option value="0"> choose category</option>
		                             	<?php
									        //connect to db to fetch fields
										   	$stmt=$conn->prepare(" SELECT * FROM categories  ORDER BY cat_id  ");
										   	$stmt->execute();
										   	$cat=$stmt->fetchAll();
											foreach ($cat as  $catf) {
											echo "<option class='option-parent' value='".$catf['cat_id']."'>".$catf['cat_nameAR']."</option>";
													}
									        ?>					
		                                </select>
		                                <!--sub categories -->
			                            <select name="categories2" id="subcat2">
			                             	<option value="0"> choose </option>
			                            </select>
			                            <span class="span-required"> * </span><br><br>
			                            <?php echo '<p>'.$fetched['subcat_nameAR'].'&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;'. $fetched['cat_nameAR'].'</p>' ?>
                                        <input type="hidden" name="cat" value="<?php echo $fetched['cat_id']?>">
                                        <input type="hidden" name="sub" value="<?php echo $fetched['subcat_id']?>">
							            </div>



                                         <label for="inputEmail3" class="col-sm-2 col-form-label">Advertiser</label>				        
					                    <div class="div-input-container edit-pic">
                                         <?php
                                         if ($fetched['sit']==1){ echo "Owner";}else{ echo "Middle man";}
                                         ?>
					                    </div>



							             <label for="inputEmail3" class="col-sm-2 col-form-label">Status</label>				        
					                    <div class="div-input-container edit-pic">
                                         <?php
                                         if ($fetched['approve']==0){ echo "Pending";}else{ echo "shown";}
                                         ?>
					                    </div>


							            <label for="inputEmail3" class="col-sm-2 col-form-label">Photos</label>				        
					                    <div class="div-input-container edit-pic">
					                    <?php
					                    if ($fetched['photo']>0) { ?><div><img src="../data/upload/<?php echo $fetched['photo'];?>"><?php if($fetched['approve']>0){ ?><a class="confirmAction" href="items.php?do=deletePhoto&id=<?php echo $fetched['item_id']?>&action=makePending">Make Pending</a><?php } ?></div> <?php }
					                    /*if ($fetched['photo2']>0) { ?><div><img src="../data/upload/<?php echo $fetched['photo2'];?>"><a class="confirm" href="items.php?do=deletePhoto&id=<?php echo $fetched['item_id']?>&action=delete2">Delete</a></div> <?php }*/
					                    ?>
							            </div>

							            

                                        <?php
							        	$user=fetch('*','user','user_id',$fetched['user_id']);
							        	?>		
							            <label for="inputEmail3" class="col-sm-2 col-form-label">User</label>				        
					                    <div class="div-input-container  ">
					                    <input type="text" class=" inputPassword  input-add-page" id="inputEmail3"  placeholder="<?php echo $user['commercial_name']?>" readonly>
					                    <input type="hidden"  name='members' value="<?php echo $user['user_id']?>" >
							            <span class="span-required"> * </span>
							            </div>



								        <div class="last-div">
								        <span class="span-required2">(*) = required</span>
					                    </div>
									    <input type="submit" name="submit" value="Edit Item">
					                </form>
					                <input type="hidden" id="lng" value="<?php echo $l;?>">
					                <!--ajax coner -->
			                       <script type="text/javascript" src="<?php echo $js; ?>jquery-3.6.0.min.js"></script>
			                       <script>
			                       $(document).ready(function(){
								       //ajax call subcats 
			                          $("#subcat").on("change", function(){
			                          var cats=$(this).val();
			                          var L=$('#lng').val();
			                          $.ajax({
			                          url:"../showSubCats.php",
			                          data:{sentCats:cats,l:L},
			                          success: function(data){                             
			                            $('#subcat2').html(data);
			                             }
			                           });
			                         });
			                          //


			                          });
			                         </script>

								    <?php
							}else{
								$redirectHomeMsg="You aren't allowed here";
							    redirectHome($redirectHomeMsg);
							}

					    //end edit page
					    //start update page
				   }elseif($do=='update'){
				       if($_SERVER['REQUEST_METHOD']=='POST')  {
									echo "<h1 class='h1-style'> Update Item </h1>";
								    // recall database to store data, then store in variables
									$name1    =!empty($_POST['name'])?trim($_POST['name']):$_POST['oldName'];
									$desc1    =!empty($_POST['description'])?trim($_POST['description']):$_POST['oldDescription'];
									$pri1     =isset($_POST['price'])?trim($_POST['price']):0;
									$cat      =$_POST['categories1']?$_POST['categories1']:$_POST['cat'];
									$sub      =$_POST['categories2']?$_POST['categories2']:$_POST['sub'];
									$mem      =$_POST['members'];
									$ITEMID   =$_POST['item_id'];

									$name=filter_var($name1,FILTER_SANITIZE_STRING);
									$desc=filter_var($desc1,FILTER_SANITIZE_STRING);
									$pri=filter_var($pri1,FILTER_SANITIZE_NUMBER_INT);

									//file
									if (isset($_FILES['photo'])) {
									$photoName=$_FILES['photo']['name'];
		                            $photoSize=$_FILES['photo']['size'];
		                            $photoTmp=$_FILES['photo']['tmp_name']; 
									$photoType=$_FILES['photo']['type'];

									//refine file upload
		                            $expl=explode(".", $photoName);
									$refinedPhotoName=strtolower(end($expl));
		                            $allowedExtensions=array('jpg','jpeg','gif','png');							
									}
			         			
			             			/////if fields are left out empty////////////						        	
				                     $error= array( );
									if (empty($name)) {
										$error[]="<div class='alert alert-danger'>Sorry! This field \"Item Name\"  is missing </div>";					 
									}
									if (strlen($name)<8) {
										$error[]="<div class='alert alert-danger'>This field \"name\" is too short </div>";
									 }  
				                     if (empty($desc)) {
										$error[]="<div class='alert alert-danger'>Sorry! This field \"Description\"  is missing</div>";					 
									}
									 if (strlen($desc)<20) {
										$error[]="<div class='alert alert-danger'>This field \"Description\" is too short </div>";
									 }  

				                     if ( empty($pri)) {
										$error[]="<div class='alert alert-danger'>Sorry! This field \"Price\"  is missing</div>";			 
									  }

									 

			                    
                                     if (!empty($error)){
				                     foreach ($error as  $value1) {
		                             echo $value1  ;
		                             echo "<a href='items.php?do=edit&id=".$ITEMID."'> Back </a>";
                             		 
		                             } 

		                             }else{

		                             	//$rndm=rand(0,100000000).'_'.$refinedPhotoName;
		                             	//move_uploaded_file($photoTmp, '..\data\upload\\'.$rndm);
		                             //connecting with database to send new data
									 $stmt=$conn->prepare('UPDATE  items  SET  title=?,description=?,
									 	price=?,cat_id=?,subcat_id=?,approve=2  WHERE  item_id=? ');
							         $stmt->execute(array($name,$desc,$pri,$cat,$sub,$ITEMID));
									 $count=$stmt->rowCount();
							         //success
									 echo '<h5>   success </h5>';
									 echo "<div class='alert alert-success'>" . $count . " Item updated  </div>";															 								 									
	                                 echo "<a href='items.php?do=edit&id=".$ITEMID."'> Back </a>&emsp;&emsp;&emsp;<a href='items.php'> Items page </a>";
                                    
	                                 }

							}else{
						     $redirectHomeMsg="You aren't allowed here";
							redirectHome($redirectHomeMsg);
							}
				           
				            echo   '</div>';

                ////////end update page///////////
	            ///////start delete page/////////
			 }elseif($do=='delete'){
					    echo "<div class='container'> ";
						echo '<h1 class="h1ManagePages"> Delete Item   </h1>';
						$ITEMID=isset($_GET['id']) && is_numeric($_GET['id'])&&$_GET['id']>0?intval($_GET['id']):0;				   
						  // call back data from database through the function "checkItem" to examine the condition 
				        $check=checkItem('item_id', 'items', $ITEMID);
				        if ($check>0) {  
						         $stmt=$conn->prepare('DELETE  FROM  items  WHERE  item_id = :zid ');
						         $stmt->bindParam(':zid', $ITEMID);
								 $stmt->execute();
								 $stmt->rowCount();
								 echo '<h5>   success </h5>';							    
							     echo "<div class='alert alert-success'>".$stmt->rowCount(). " Item deleted </div>";     
							     echo "<a href='items.php'> Go to items page </a>";
			        	}else{
		        		$redirectHomeMsg='This sign isn\'t exisiing';	
		        		redirectHome($redirectHomeMsg);			        		 			                				        		 
			        	}

					   	echo '</div>';
               /////// End delete page     /////////
              /////////start approve page/////////
			}elseif ($do=='deletePhoto') {

				$ITEMID=isset($_GET['id']) && is_numeric($_GET['id'])&&$_GET['id']>0?intval($_GET['id']):0;				   
				$check=checkItem('item_id', 'items', $ITEMID);

				if ($check>0) {
					if (isset($_GET['action'])&&$_GET['action']=='makePending') {
						$stmt=$conn->prepare('UPDATE  items  SET  approve=0 WHERE  item_id=? ');
				        $stmt->execute(array($ITEMID));
					}
                    //if done
					if($stmt){ 
						echo "<div class='center above-lg'><a href='items.php?do=edit&id=".$ITEMID."'> Back </a>&emsp;&emsp;&emsp;<a href='items.php'> Items page </a>&emsp;&emsp;&emsp; <a href='dashboard.php'> Dashboard </a></div>"; 
					    echo "<span class='block-green'>Success</span>";
					}
                  }


			}elseif($do=='approve'){
				   	     echo "<div class='container'> ";
						 echo '<h1 class="h1ManagePages"> Approve Item   </h1>';

						 if(isset($_GET["id"]) && is_numeric($_GET["id"]) && $_GET["id"]>0  ){
						    $ITEMID=intval($_GET["id"]);//item_id
						   /* $user_id=$_GET['user']; //user posted item
						    $fetch=fetch("*", "items","item_id", $ITEMID);
						    $date=$fetch['item_date'];*/

						  // check if item is found
				          $check=checkItem("item_id", "items", $ITEMID);
						 // Update if item is found
				         if ($check>0){
						    $stmt=$conn->prepare('UPDATE  items  SET  approve=1,hide=0  WHERE  item_id =? ');
							$stmt->execute(array($ITEMID));
							$stmt->execute();
							
								if ($stmt) {
								 echo '<h5>   success </h5>';						    
							     echo "<div class='alert alert-success'> Item approved </div>";
							     echo "<a href='items.php'> Back </a>";
							     //add info in notify table to notify followers
							     
						          
		                        }else{ //if not($stmt)
		                        	echo "Error with uploading . check internet connection and try again.";
		                        }


		        	 }else{	// END IF ITEM IS NOT EXISITING	        		
	        		 $redirectHomeMsg='This sign isn\'t exisiing';	
	        		 redirectHome($redirectHomeMsg);			        		 			                				        		 
		        	 }

					        	echo '</div>';
               } //END IF(isset)
			/////////end approve page
			}elseif ($do=='renew') {
				
			} // END elseif
                      

		

   
}else{
	header('location:index.php');
	exit();
}

include  $tmpl ."footer.inc";
ob_end_flush();
?>