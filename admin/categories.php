<?php

ob_start();//to stop problems caused by header
session_start();

if (isset($_SESSION['idAdmin']) && $_SESSION['idAdmin'] ==84) {	
   $title='categories';
   include 'init.php';

   $do=isset($_GET['do']) ? $_GET['do'] : 'manage';//short if
   //start categories page
   if ($do=='manage'){
         
   	               $sorting='ASC';   //change ordering
   	               if (isset($_GET['sort']) && $_GET['sort']=='DESC') {
   	               	$sorting='DESC';
   	               }

			   	//connect to db to fetch fields
			   	$stmt=$conn->prepare(" SELECT * FROM categories  ORDER BY cat_id $sorting");
			   	$stmt->execute();
			   	$fetched=$stmt->fetchAll();
			   	?>
			   	<h1 class="edit-h1"> Manage categories</h1>
			   	<div class=" container-categories">
				   		<div class="container-categories-heading">
				   		All categories
					   		<div class="ASC">
						   		<span class="span-lable">Sort by</span>&nbsp;&nbsp;&nbsp;
						   		[<a class="<?php if($sorting=='ASC'){echo "active";} ?> span-black" href="categories.php?sort=ASC">ASC</a>&nbsp;&nbsp;
						   		<a class="<?php if($sorting=='DESC'){echo "active";} ?> span-black" href="categories.php?sort=DESC">DESC</a>]
					   	    </div>
				   	    </div>
				   	<div class="container-categories-body">
				   		  <?php
				   			foreach ($fetched as  $value) {
				   				   echo '<div class="div-relative">';
					   			   echo '<span class="span-heading">Name: '.$value ['name'].'</span><br>';
	                               echo "<button class='btn  bcat'><a href='categories.php?do=edit&ID=".$value['cat_id']."'><img src='layout/images/edit2.png'></a></button>"; // edit category 
	                               echo '<a href="categories.php?do=delete&ID='.$value["cat_id"].'" class="btn bcat2 confirm confirmAction"><i class="fas fa-trash"></i></a>'; 
					   				
					   				/*
					   				if ($value ['visibility']==1) {echo "visibility: <span class='span-red'>Hidden</span> ";}				   										   				
					   				if ($value ['allow_comments']==1) {echo "comments: <span class='span-red'>Disabled</span> ";}				   									   				
					   				if ($value ['allow_ads']==1) {echo "ads: <span class='span-red'>Disabled</span> ";}	
					   				*/			   					
					   				$stmt=$conn->prepare("SELECT * FROM sub 
                                      join categories on sub.cat_id=categories.cat_id
					   				  where categories.cat_id=?    ");
								     $stmt->execute(array($value['cat_id']));
								     $subCat=$stmt->fetchAll();

                                      if(!empty($subCat)){
								      echo '<br><span> Sub categories  </span><br>';
					   				  foreach ($subCat as  $sub) {
					   				  echo "<p>".$sub['subcat_name']."&emsp;<a class='span-red' href='categories.php?do=edit&id=".$sub['subcat_id']."'>Edit</a></p>";
					   				   }}//

					   				echo '</div>';
					   				echo '<hr class="hr-loop">';
				   				} 
				   			    
				   		  ?>				   			
				   	</div>
				       	 <a href="categories.php?do=add" class="btn btn-primary cat-btn"> Add new category  </a>
				       	 <a href="categories.php?do=add&type=sub" class="btn btn-primary cat-btn"> Add new sub-category  </a>
			   	 </div>
			   <?php
   }elseif ($do=='add') {
   	          if (! isset($_GET['type'])) { //add category
	        	?>
	        	<form class="form-edit" id="form-add" action="?do=insert" method="POST">
				    	<h1 class="h1-style ">  Add new category </h1>
				    	<input type="Hidden" name="addCat">			 
		  	        <label for="inputEmail3" class="col-sm-2 col-form-label">Name</label>
			        <div class="div-input-container  "> 
			        <input type="text" class="  input-add-page" id="inputEmail3" name="name" autocomplete="off"  >
		            <span class="span-required"> * </span>
		            </div>

		            <label for="inputEmail3" class="col-sm-2 col-form-label">Arabic Name</label>
			        <div class="div-input-container  "> 
			        <input type="text" class="input-add-page" id="inputEmail3" name="nameAR" autocomplete="off"  >
		            <span class="span-required"> * </span>
		            </div>

                  
			        <label for="inputEmail3" class="col-sm-2 col-form-label">Description</label>				        
                    <div class="div-input-container  ">
			        <input type="text" class=" inputPassword  input-add-page" id="inputEmail3" 
			        name='description' placeholder=" Description mustn't be less than 16 characters" autocomplete="off" >
		            <span class="span-required"> * </span>
		            </div>
                     

				           
			        <div class="last-div">
			        <span class="span-required2"> (*) required</span>
                    </div>

				    <input type="submit" name="submit" value="Add category">
				    <h1 id="show"></h1>	
                </form>

		            <?php }else{ // add subcategory
                         ?>
	        	<form class="form-edit" id="form-add" action="?do=insert" method="POST">
				    	<h1 class="h1-style ">  Add new sub-category </h1>			 
		  	        <label for="inputEmail3" class="col-sm-2 col-form-label">Name</label>
			        <div class="div-input-container  "> 
			        <input type="text" class="  input-add-page" id="inputEmail3" name="name" autocomplete="off"  >
		            <span class="span-required"> * </span>
		            </div>

		            <label for="inputEmail3" class="col-sm-2 col-form-label">Arabic Name</label>
			        <div class="div-input-container  "> 
			        <input type="text" class="input-add-page" id="inputEmail3" name="nameAR" autocomplete="off"  >
		            <span class="span-required"> * </span>
		            </div>

                  
			        <label for="inputEmail3" class="col-sm-2 col-form-label">Category </label>				      
                    <div class="div-input-container  ">
			        <select class=" inputPassword  input-add-page  Cat" id="inputEmail3"  name='cat'>
			        	<option value="0">choose</option>
					        <?php
						   	$stmt=$conn->prepare(" SELECT * FROM categories ");
						   	$stmt->execute();
						   	$fetched=$stmt->fetchAll();
							foreach ($fetched as  $cat) {
							echo "<option class='option-parent' value='".$cat['cat_id']."'>".$cat['name']. "</option>";
							} ?>        	
			        </select>
		            <span class="span-required"> * </span>
		            </div>
                     
				           
			        <div class="last-div">
			        <span class="span-required2"> (*) required</span>
                    </div>

				    <input type="submit" name="submit" value="Add sub-category">
				    <h1 id="show"></h1>	
                </form>
           <?php } ?>

               

	        	<?php
   }elseif($do=='insert'){
   	                //insert page
					if($_SERVER['REQUEST_METHOD']=='POST')  {
						      if (isset($_POST['addCat'])) { //add category
						     
								echo "<div class='container'> ";	
								echo "<h1 class='text-center  h1ManagePages' > Insert category </h1>";
							    //store data in variables
								$name     =trim($_POST['name']);
								$nameAR   =trim($_POST['nameAR']);
								$desc     =trim($_POST['description']);
								
								if (empty($name)||empty($nameAR)||empty($desc)) {    //if name is empty
									    echo "<div class='alert alert-danger'> Fill out empty fields </div>";	
									    echo "<a href='categories.php?do=add'> Back </a>"; 				 
								       }
			                    if (!empty($name) && !empty($nameAR)) {   //if name is not empty
				                     	  //check name availability in db
			                    	      
				                     	  $check=checkItem('name','categories',$name);
				                     	  $check2=checkItem('nameAR','categories',$nameAR);
				                     	  if ($check == 1 ) {
		                                		echo "<div class='alert alert-danger'>Sorry! this Name \"  ".$name. "\" is taken. choose a different name</div>";
					                     		echo "<a href='categories.php?do=add'> Back </a>"; 
					                      }elseif ($check2 == 1) {
					                      	    echo "<div class='alert alert-danger'>Sorry! this Arabic Name \"  ".$nameAR. "\" is taken. choose a different name</div>";
					                     		echo "<a href='categories.php?do=add'> Back </a>"; 
					                      }else{
					                  	  //connecting with database to insert new category
									      $stmt=$conn->prepare('INSERT INTO  
										 	categories(name, description,nameAR)
										    VALUES (:zname,  :zdesc,:znameAR )');
								          $stmt->execute(array( 
											   "zname"     =>   $name,
											   "zdesc"     =>   $desc,
											   "znameAR"   =>   $nameAR
								               ));

										   $stmt->rowCount();
								            //success
										    echo '<h5>   success </h5>';
										    echo "<div class='alert alert-success text-center'>".$stmt->rowCount(). " category added</div>";
										    echo "<a class='bottom2' href='categories.php'> Back </a>"; 
										   
											}			
			                          }   
			                   }else{ //add sub category
			                   	echo "<div class='container'> ";	
								echo "<h1 class='text-center  h1ManagePages' > Insert category </h1>";
							    //store data in variables
								$name     =trim($_POST['name']);
								$nameAR   =trim($_POST['nameAR']);
								$cat     =$_POST['cat'];
								
								if (empty($name)||empty($nameAR)||empty($cat)) {    //if name is empty
									    echo "<div class='alert alert-danger'> Fill out empty fields </div>";	
									    echo "<a href='categories.php?do=add&type=sub'> Back </a>"; 				 
								       }
			                    elseif (!empty($name) && !empty($nameAR)) {   //if name is not empty
				                     	  //check name availability in db
				                     	 $check=checkItem('subcat_name','sub',$name);
				                     	 $check2=checkItem('subcat_nameAR','sub',$nameAR);
				                     	
				                     	  if ($check==1 ) {
		                                		echo "<div class='alert alert-danger'>Sorry! this Name \"  ".$name. "\" is taken. choose a different name</div>";
					                     		echo "<a href='categories.php?do=add&type=sub'> Back </a>"; 
					                      }elseif ($check2==1) {
					                      	    echo "<div class='alert alert-danger'>Sorry! this Arabic Name \"  ".$nameAR. "\" is taken. choose a different name</div>";
					                     		echo "<a href='categories.php?do=add&type=sub'> Back </a>"; 
					                      }else{
					                  	  //connecting with database to insert new category
									      $stmt=$conn->prepare('INSERT INTO  
										 	sub(subcat_name, subcat_nameAR,cat_id)
										    VALUES (:zname,  :znameAR,:zcat )');
								          $stmt->execute(array( 
											   "zname"     =>   $name,
											   "znameAR"   =>   $nameAR,
											   "zcat"      =>   $cat
								               ));

										   $stmt->rowCount();
								            //success
										    echo '<h5>   success </h5>';
										    echo "<div class='alert alert-success text-center'>".$stmt->rowCount(). " sub-category added</div>";
										    echo "<a class='bottom2' href='categories.php'> Back </a>"; 
											}			
			                          }

			                   }           
						
					}else{				    
					$redirectHomeMsg="You aren't allowed here";
					redirectHome($redirectHomeMsg);
					}
		           
		            echo   '</div>';

          ///////End insert page//////////////////
               //edit page

   }elseif($do=='edit'){
                    	//edit cats
					   if (isset($_GET['ID']) && is_numeric($_GET['ID'])) {
					   	$CATID=intval($_GET['ID']);
					   		//Bring user data from database
						 $stmt=$conn->prepare("SELECT * FROM categories	WHERE cat_id=? ");
						 $stmt->execute(array($CATID));
						 $fetched=$stmt->fetch();
						 $count=$stmt->rowCount();
                         //echo $count;

				        if ($count>0) {	
	
					      ?>    <!--if condition is true, show form-->
			        	  <form class="form-edit formCat" action="?do=update" method="POST">
						    	<h1 class="h1-style">  Edit category </h1>
						    	<input type="Hidden" name="cat_id" value="<?php echo $fetched['cat_id'] ?>">			 
				  	       
				  	        <label for="inputEmail3" class="col-sm-2 col-form-label">Name</label>
					        <div class="div-input-container  "> 
					        <input type="text" class="  input-add-page" id="inputEmail3" name="name" value="<?php echo $fetched['name'] ?>" >
				            <span class="span-required"> * </span>
				            </div>

				            <label for="inputEmail3" class="col-sm-2 col-form-label">Arabic Name</label>
					        <div class="div-input-container  "> 
					        <input type="text" class="  input-add-page" id="inputEmail3" name="nameAR" value="<?php echo $fetched['nameAR'] ?>" >
				            <span class="span-required"> * </span>
				            </div>
		                 
					        <label for="inputEmail3" class="col-sm-2 col-form-label">Description</label>				        
		                    <div class="div-input-container  ">
					        <input type="text" class=" inputPassword  input-add-page  des" id="inputEmail33" 
					        name='description' placeholder=" Description mustn't be less than 16 characters" value="<?php echo $fetched['description'] ?>" >
				            </div>
		                     
						   
					        <div class="last-div">
					        <span class="span-required2"> (*) required</span>
		                    </div>
						    <input id="catInput" type="submit" name="submit" value="Update category">	
		                 </form>

			   	        <?php
								
				  }else{
					$redirectHomeMsg="You aren't allowed here";
					redirectHome($redirectHomeMsg);
				  }

				  //edit subcats
			   }elseif (isset($_GET['id']) && is_numeric($_GET['id'])) {
			   	$sub=intval($_GET['id']);
			   	//Bring user data from database
				 $stmt=$conn->prepare("SELECT * FROM sub
				 	join categories on sub.cat_id=categories.cat_id
				 	WHERE subcat_id=? ");
				 $stmt->execute(array($sub));
				 $fetched=$stmt->fetch();
				 $count=$stmt->rowCount();
		        if ($count>0) {	

			      ?>    <!--if condition is true, show form-->
	        	  <form class="form-edit formCat" action="?do=update" method="POST">
				    	<h1 class="h1-style">  Edit sub-category </h1>
				    	<input type="Hidden" name="subcat_id" value="<?php echo $fetched['subcat_id'] ?>">			 
		  	       
		  	        <label for="inputEmail3" class="col-sm-2 col-form-label">Name</label>
			        <div class="div-input-container  "> 
			        <input type="text" class="  input-add-page" id="inputEmail3" name="name" value="<?php echo $fetched['subcat_name'] ?>" >
		            <span class="span-required"> * </span>
		            </div>
	             
			        <label for="inputEmail3" class="col-sm-2 col-form-label">Arabic Name</label>
			        <div class="div-input-container  "> 
			        <input type="text" class="  input-add-page" id="inputEmail3" name="nameAR" value="<?php echo $fetched['subcat_nameAR'] ?>" >
		            <span class="span-required"> * </span>
		            </div>

		            <label for="inputEmail3" class="col-sm-2 col-form-label">Category</label>
			        <div class="div-input-container  "> 
			        <select name="cats" class="  input-add-page">
			        	<?php
			        	$stmt=$conn->prepare("SELECT * FROM categories ");
						 $stmt->execute();
						 $cats=$stmt->fetchAll();
						 if (!empty($cats)) {
						 	foreach ($cats as $cat) {
						 		echo "<option value='".$cat['cat_id']."'";if($cat['cat_id']==$fetched['cat_id']){echo "selected";} echo ">".$cat['name']."</option>";
						 	}
						 } ?>
			        </select>
		            <span class="span-required"> * </span>
		            </div>
	             
				   
			        <div class="last-div">
			        <span class="span-required2"> (*) required</span>
	                </div>
				    <input id="catInput" type="submit" name="submit" value="Update category">	
	             </form>
			<?php   } }
					 
					

       /////////edit page finished
	  /////////update page started
   }elseif($do=='update'){
   								
					if($_SERVER['REQUEST_METHOD']=='POST')  {
							echo "<h1 class='h1-style'> Update category </h1>";
							
							if (isset($_POST['cat_id'])) { //update categories
						    // recall database to store data, then store in variables
							$name     =trim($_POST['name']);
							$nameAR   =trim($_POST['nameAR']);
							$desc     =trim($_POST['description']);
							$CATID    =$_POST['cat_id'];							
						
		         			/////if fields are left out empty////////////
		         			//$errors=[];
					        echo "<div class='container'> ";				                     
					                     
			                     if (empty($name)||empty($nameAR)||empty($desc) ) {  //if description is left empty
									echo "<div class='alert alert-danger'>Sorry! some fields are missing</div>";
									echo "<a href='categories.php?do=edit&ID=".$CATID."'> Back </a>";					 
							 	 }
			                    		                         
		                         elseif (strlen($name)<2||strlen($nameAR)<2||strlen($desc)<20 ) {	//if description is short								
									echo "<div class='alert alert-danger'>Sorry! some fields are too short</div>";		 								    
								    echo "<a href='categories.php?do=edit&ID=".$CATID."'> Back </a>";

								 }else{  
									 //connecting with database to send new data
									 $stmt=$conn->prepare('UPDATE categories SET name=?,nameAR=?,description=?
									 	 WHERE cat_id=? ');
							         $stmt->execute(array($name,$nameAR,$desc,$CATID));
									 $count=$stmt->rowCount();
							         //success
									 echo '<h5>   success </h5>';
									 echo "<div class='alert alert-success'>" . $count . " category updated  </div>";
									 echo "<a href='categories.php'> Back </a>";
								     }
							}else{ //update sub-catsgories
                             $name     =trim($_POST['name']);
							 $nameAR   =trim($_POST['nameAR']);
							 $CATID    =$_POST['cat_id'];	
							 $sub_id   =$_POST['subcat_id'];							
						
		         			/////if fields are left out empty////////////
		         			//$errors=[];
					        echo "<div class='container'> ";				                     
					                     
		                     if (empty($name)||empty($nameAR) ) {  //if description is left empty
								echo "<div class='alert alert-danger'>Sorry! some fields are missing</div>";
								echo "<a href='categories.php?do=edit&ID=".$CATID."'> Back </a>";					 
	                        }elseif (strlen($name)<2 || strlen($nameAR)<2) {	//if description is short								
								echo "<div class='alert alert-danger'>Sorry! some fields are too short</div>";		 								    
							    echo "<a href='categories.php?do=edit&ID=".$CATID."'> Back </a>";
							 }else{  
								 //connecting with database to send new data
								 $stmt=$conn->prepare('UPDATE sub SET subcat_name=?,subcat_nameAR
								 	 WHERE subcat_id=? ');
						         $stmt->execute(array($name,$nameAR,$sub_id));
								 $count=$stmt->rowCount();
						         //success
								 echo '<h5>   success </h5>';
								 echo "<div class='alert alert-success'>" . $count . " sub-category updated  </div>";
								 echo "<a href='categories.php'> Back </a>";
							     }
							}								 								 									

					}else{

				     $redirectHomeMsg="You aren't allowed here";
					redirectHome($redirectHomeMsg);
					}
		           
		            echo   '</div>';


	 //delete page
   }elseif($do=='delete'){
   	echo "<div class='container'> ";
				echo '<h1 class="h1ManagePages"> Delete catagory   </h1>';
				$CATID=isset($_GET['ID']) && is_numeric($_GET['ID'])?intval($_GET['ID']):0;
		    
				  // call back data from database through the function "checkItem" to examine the condition 
		        $check=checkItem('cat_id', 'categories', $CATID);
		         
				 //if condition is ok, call back data from database AGAIN to carry out deletion                       
		        if ($check>0) {  // it should be like this =>[if ($check>)1{]
			         $stmt=$conn->prepare("DELETE  FROM  categories  WHERE  cat_id =?");
					 $stmt->execute(array($CATID));
					 $stmt->rowCount();

					 echo '<h5>   success </h5>';
				     echo "<div class='alert alert-success'>".$stmt->rowCount(). " category deleted </div>";     
				     echo "<a href='categories.php'> Back </a>";	 

	        	}else{
        		
        		$redirectHomeMsg='This category isn\'t exisiing';	
        		redirectHome($redirectHomeMsg);			        		 		 
	        	}

			    echo '</div>';
   }


   //end categories page
   include $tmpl ."footer.inc";
}else{ //END IF (SESSION[''])
	header('location:index.php');
	exit();
}
ob_end_flush();
?>