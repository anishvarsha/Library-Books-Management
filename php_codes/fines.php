<?php include "head.php"; ?>
<div >
 <br>
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post"  >
   <input class = "search" type="text" name="search" placeholder="Search by Borrower's CARD_ID" id ="search"  />
    <input class="button"  type="submit" name="search1" />
  </form>
  <?php
  include "connect.php";
  
    if((isset($_POST['search']) && $_POST['search'] != NULL) || $_GET['search'] != NULL) 
      { 
         if($_POST['search'] != NULL){
        $search = $_POST['search'];
        //echo $search ;
        }
        else{
          $search = $_GET['search'];
         // echo $search;
         // echo "yooo";
        }

        if (isset($_GET['check'])) {
            
            //   echo $_GET['loan_id'];
            // echo "asdf";
             $loan = $_GET['loan_id'];
            echo $loan;


             $update_loan_date = "UPDATE fines
                                  SET PAID = 1
                                  where loan_id = {$loan}";
            $updating = $db->query($update_loan_date) ;

          //  $updated = mysqli_fetch_array($updating);
         
          echo '<script language="javascript">';
          echo 'alert("Payment Done Successfully")';
          echo '</script>';
          }


        //$search = "";
        echo "<br><br>Results for Search Text: <b> $search </b>";



        $sql="SELECT  L.LOAN_ID,L.due_date,L.date_in, L.ISBN13, BW.CARD_ID, CONCAT(first_name,' ',last_name) AS BNAME,FINE_AMT,PAID
        FROM FINES F, BOOK_LOANS L, BORROWER BW 
        WHERE
                BW.CARD_ID  = '{$search}'
                AND
                BW.CARD_ID = L.CARD_ID
                AND
                F.LOAN_ID = L.LOAN_ID
              
                 ORDER BY L.due_date "; 
        //-run  the query against the mysql query function 
        $result= $db->query($sql); 
        //-create  while loop and loop through result set 
      //  echo "YOOO";
        if($result->num_rows > 0){
         

          echo"<div style='overflow-x:auto;'>
          <table>
          <tr>
              <th>CARD_ID</th>
              <th>Borrower</th>
              <th>ISBN13</th>
              <th>Due Date</th>
              <th>Date In</th>
              <th>Fine_Amount</th>
              <th>Payment Status</th>
  
          </tr>";
          while($rows = $result->fetch_assoc()){ 

            $ISBN=$rows['ISBN13']; 
            $CARD_ID=$rows['CARD_ID'];
            $BNAME = $rows['BNAME'];
            $SSN = $rows['SSN'];
            $LOAN_ID = $rows['LOAN_ID'];
            $DUE_DATE = $rows['due_date'];
            $DATE_IN = $rows['date_in'];
            $PAID = $rows['PAID'];
            $FINE_AMT = $rows['FINE_AMT'];
            $unix_time_due = strtotime($DUE_DATE); 

            $unix_time_in = strtotime($DATE_IN);
 
            echo "   
                <tr>
                  <td>".$CARD_ID."</td>
                  <td>".$BNAME."</td>
                  <td>" . $ISBN."</td>
                  <td>".date('F j, Y, g:i a', $unix_time_due)."</td>
                  ";
                  if(is_null($DATE_IN)){
                    echo "<td>Yet to Submit</td>";
                  }
                  else{
                  echo "<td>".date('F j, Y, g:i a', $unix_time_in)."</td>";}

                  echo"<td>".$FINE_AMT."</td>";

              if($PAID  == 0){
                   echo " <td>
                   ";
                   ?>
                   
                      <form action='<?php echo $_SERVER['PHP_SELF']."?search=$search"; ?>' method= 'GET'>
                    <input type='hidden' name='loan_id' value='<?php echo $LOAN_ID; ?>'/>
                    <input type='hidden' name='search' value='<?php echo $search; ?>'/>
                     <input type='submit' name='check' value='PAY' class='button button2'/>
                     </form>
                
                    </td>
                    <?php
                  }
                  else{
                    echo " <td>
                   <b> PAID</b>              
                    </td>";

                  }    
               
          echo "</tr>";  
          }    
    
        echo "</table> </div>";
        }
       else{ 
          echo  "<p>Please enter any details related to Loan: NO RESULTS FOUND</p>"; 
        } 
      } 
    else{
        echo "Type ISBN or TITLE or Author's name of the BOOK or SSN or borrower's ID  </b>";
    }
    ?>
  

  </div>


</body>
</body>
</html>