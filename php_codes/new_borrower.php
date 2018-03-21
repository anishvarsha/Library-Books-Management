<?php include "head.php"; ?>
<h3>New Borower Details</h3>

<div class="form1">
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
  <label for="fname">CARD ID</label>
    <input class="form" type="text" id="card_id" name="card_id" required><br>

    <label for="fname">First Name</label>
    <input class="form" type="text" id="fname" name="firstname" required><br>

    <label for="lname">Last Name</label>
    <input  class="form" type="text" id="lname" name="lastname" required><br>
  
    <label for="ssn">    Social Security Number</label>
    <input  class="form" type="text" id="ssn" name="ssn" required pattern='\d{3}[\-]\d{2}[\-]\d{4}' title=' (SSN Format: "999-99-9999"' 
    onblur="addDashes(this)" ><br>

    <label for="address">ADDRESS</label>
    <input  class="form" type="text" id="address" name="address" required><br>
    
    <label for="lname">Phone Number</label>
    <input class="form" id="phone" name="phone" type='text'  required pattern='\[\(]\d{3}[\)\s][\-]\d{3}[\-]\d{4}' title='Phone Number Format: 999-999-9999'
    onblur="addDashesPhone(this)" > <br>

    <label for="lname">Email</label>
    <input  class="form" type="email" id="email" name="email" required><br>

  

    <input class="formsubmit" align="center"  type="submit" value="Submit">
  </form>
</div>
 <SCRIPT LANGUAGE="JavaScript">
function addDashes(f)
{
    if(f.value.length == 9){
        f.value = f.value.slice(0,3)+"-"+f.value.slice(3,5)+"-"+f.value.slice(5,9);
}
}
</SCRIPT>
<SCRIPT>
function addDashesPhone(f)
{
    if(f.value.length == 10){
    var output= "("+f.value.slice(0,3)+") " + f.value.slice(3,6) + "-" + f.value.slice(6,10);
    f.value = output;
}
}
</SCRIPT>
<?php
    if(empty($_POST) == false) 
    { 
        $fname = $_POST['firstname'];
        $lname = $_POST['lastname'];
        $ssn = $_POST['ssn'];
        $card_id = $_POST['card_id'];
        $address = $_POST['address'];
        $phone= $_POST['phone'];
        $email = $_POST['email'];
        include "connect.php";
        $verify = "SELECT count(ssn) FROM BORROWER WHERE ssn = '{$ssn}' ";
        $result= $db->query($verify); 
        $row=mysqli_fetch_array($result);
        //-create  while loop and loop through result set 
       // echo $row['count(ssn)'];
        if($row['count(ssn)'] < 1){
            $sql=  "INSERT into BORROWER (card_id,first_name,last_name,ssn,address,phone,email) VALUES ('$card_id','$fname','$lname','$ssn','$address','$phone','$email')";
            if ($db->query($sql) === TRUE) {
                echo '<script language="javascript">';
                echo 'alert("Borrower Record Added Successfully")';
                echo '</script>';
            }
            else {
                echo "Error: <br>" . $db->error;       
            }
        }
       else{
            echo '<script language="javascript">';
            echo 'alert("Duplicate SSN, Customer Already Exists or Wrong SSN Given")';
            echo '</script>';
        }
    }
?>

</body>
</html>
