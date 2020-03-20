
<?php

require_once('db_connection.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rate Us</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">

   
  <style>
  
    body, html, .container, .reviews_container {
        height: 100%;
}


*{

   text-align: center;

 }
 
 th {
   width: 550px;
   padding-top: 20px;
   
 }
 tr {
   width: 100%;
  
 }

 table {
   border-bottom: 2px solid #999;
   padding: 5px;
 }

 
.gt-input {
    width: 100%;
    box-shadow: 3px 2px 3px 2px #999;
    margin: 25px, 0px, 25px, 0px;
}
.rateyo, #rating {
    justify-content: center;
    align-items: center;
    display: flex;
    width: 100%;
    text-align: center;
}

input[type=submit] , a {
    background-color: #333253;
    border: none;
    color: white;
    padding: 16px 32px;
    text-decoration: none;
    margin: 4px 2px;
    cursor: pointer;
}

label {
    color: #999;
    font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif;
    text-transform: uppercase;
    font-size: 22px; 
    letter-spacing: 4px;
    padding: 25px;
}

textarea {
    padding: 30px;
}

.form-status {
    font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
    color: green;
    font-weight: bold;
    text-transform: uppercase;
    padding: 30px;
}




  </style>



</head>




<?php

$status = "";

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST["name"];
    $rating = $_POST["rating"];
    $comments = $_POST["comments"];

    if(empty($name) || empty($rating) || empty($comments)) {
        $status = "All fields are compulsory.";
      } else {
        if(strlen($name) >= 255 || !preg_match("/^[a-zA-Z-'\s]+$/", $name)) {
          $status = "Please enter a valid name";
        } else {

        $sql = "INSERT INTO ratee (name, rating, comments) VALUES (:name, :rating, :comments)";

        $stmt = $pdo->prepare($sql);
        
        $stmt->execute(['name' => $name, 'rating' => $rating, 'comments' => $comments]);
  
        $status = "Your message was sent! Thank you for providing that valuable feedback. ";
        $name = "";
        $rating = "";
        $comments = "";
      }

    }
}



?>



<body>


<div class="container">
    <div class="row">
      <div class="col-lg-1"></div>


      <div class="col-lg-10">
        <form action="add_rate.php" method="post">
            <div class="title"> 
            <a href="index.php"> Go back Home</a>
                <h3 style="padding-top: 35px;">How'd We Do? </h3>
                <p> We value our customers feedback and opinions.<br> 
                <h6 class="text-warning"> Rate our services </h6><br>
                If you have had the pleasure of working with Southern Security ,  please kindly leave a comment below on how your experience was. 
                    </p>
             </div>

             <div class="input_fields">
                <label> Name </label>
                <input type="text" name="name" class="gt-input"
          value="<?php if($_SERVER['REQUEST_METHOD'] == 'POST') echo $name ?>"><br>
                
                 <label> Comments </label>
                <textarea name="comments" class="gt-input"
          value="<?php if($_SERVER['REQUEST_METHOD'] == 'POST') echo $comments ?>"> </textarea> 
             </div>

           
             <div class="rateyo" name="rating" id="rating" 
             data-rateyo-rating="4"
             data-rateyo-num-stars="5"
             data-rateyo-score="3">
            </div>
                 

            <span class="result">0</span>
            <input type="hidden" name="rating">
           
               <div class="button_container">
                <input type="submit" name="add" value="Submit"> 
                <input type="submit"  value="Display" class="display" id="display" name="display">
            </div>

            

              <div class="form-status">
               <?php echo $status; 
               ?>
              </div>

            </form>
      

            
    </div> <!-- END OF COL-LG-9 -->  
    <div class="col-lg-1"></div>


  </div> <!--END OF ROW-->
        
 </div>         
        




    <div class="container reviews_container" id="clickshow">
           <h4 style="padding: 20px;"> Reviews from Customers </h4>
                            
           <?php

           if(isset($_POST['display'])) {

             $sql = "SELECT * FROM ratee";
             $run = $pdo->query($sql);

             if($run)
             {

               while($row = $run->fetch(PDO::FETCH_OBJ)) 

               echo ' <table>
                       <tr>
                     
                       <th> Customer Name  </th>
                       <th> Star Rating  </th>
                       <th> Comments  </th>
                       </tr>
                       <tr>
                    
                       <td> '.$row->name.'   </td>
                       <td> '.$row->rating.'   </td>
                       <td> '.$row->comments.'   </td>
                     
                     </tr>

                   </table>

               ';
             } 
             else {
               echo '<script> alert("No record found")  </script>';
             }

           }
?>
</div>





<!-- Latest compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>

<script>
 
    $(function () {
        $(".rateyo").rateYo().on("rateyo.change", function(e, data) {
            var rating = data.rating;
            $(this).parent().find('.score').text('score :' + $(this).attr('data-rateyo-score'));
            $(this).parent().find('.result').text('rating :'+ rating);
            $(this).parent().find('input[name=rating]').val(rating); 
        });

        $("#display").on('click', function(){
             $(".reviews_container").Toggle();

            });     
        });   
</script>

      


</body>
</html>

