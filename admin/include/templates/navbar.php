<?php
if(!session_id()) {
    session_start(); 
}

?>
<!-- As a heading -->
<nav class="navbar navbar-light bg-light fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="#"><?php echo lang('logo')?></a>
    
     <section id="dropdown-container">
         <!-- <div class="div-img-dropdown">-->
            <!--<img id="img-dropdown" src="layout/images/user2.png" >-->
                <!--  the dropdown  -->
                <form action="processAdmin.php" method="POST">
                <select name="nav">
                  <option  value="1"><a  href="dashboard.php">Dashboard</a></option>
                  <option  value="2"><a  href="members.php?do=edit&id=<?php echo $_SESSION['idMos'] ?>">Edit my profile</a> </option>
                  <option  value="3"><a  href="categories.php">categories</a></option>
                  <option  value="4"><a  href="../index.php">Mostafed</a></option>
                  <option  value="5"><a  href="logout.php">Log out</a> </option>
                </select>
                <input type="hidden" name="session" value="<?php echo $_SESSION['idMos'];?>">
                <button type="submit">ok</button>
              </form>
             <!--<div class="div-img-dropdown-absolute">
             <p id="p-username"> <?php echo $_SESSION['name']; ?> </p>
                 <ul> 
                    <li><a  href="../index.php">Mostafed</a> </li>
                    <li><a  href="members.php?do=edit&id=<?php echo $_SESSION['idMos'] ?>">Edit my profile</a> </li>
                    <li><a  href="dashboard.php">Dashboard</a> </li>
                    <li><a  href="categories.php">categories</a> </li>
                    <li><a  href="logout.php">Log out</a> </li>
                 </ul>
             </div>
          </div>-->
      </section>  
<span class="p-username">Hi <?php if($_SESSION['nameMos']){ echo ' '.$_SESSION['nameMos']; }else{ echo ' User'; } ?></span> 
          <!--<img id="img-favourites" src="layout/images/star-yellow.png">
      end of the div with the image and dropdown -->

    
  </div>
</nav>
<!--ajax coner -->
      <script type="text/javascript" src="<?php echo $js; ?>jquery-3.6.0.min.js"></script>
      <script>
      $(document).ready(function(){ 
        //ajax call state
        $("#n").on("submit", function(){
          var navVal=$(this).val();
          $.ajax({
          url:"processAdmin.php",
          data:{val:navVal}
           });
        });
        //


         });
       </script>
 
