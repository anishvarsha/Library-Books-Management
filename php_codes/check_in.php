<?php include "head.php"; ?>
<div >
 <br>
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post"  >
   <input class = "search" type="text" name="search" placeholder="Search by Loan_ID, Book Name or by ISBN or by Borrower's CARD_ID or SSN" id ="search"  />
    <input class="button"  type="submit" name="search1" />
  </form>
  <?php
  include "connect.php";
  
    if((isset($_POST['search']) && $_POST['search'] != NULL) || $_GET['search'] != NULL)
      { 
        if($_POST['search'] != NULL){
        $search = $_POST['search'];
        echo $search ;
        }
        else{
          $search = $_GET['search'];
          echo $search;
         // echo "yooo";
        }


        //$search = "";
        echo "<br><br>Results for Search Text: <b> $search </b>";

        if (isset($_GET['check'])) {
            
            //   echo $_GET['loan_id'];
           //  echo "asdf";
             $loan = $_GET['loan_id'];
           // echo $loan;


             $update_loan_date = "UPDATE book_loans
                                  SET date_in = now()
                                  where loan_id = {$loan}";
            $updating = $db->query($update_loan_date) ;

          //  $updated = mysqli_fetch_array($updating);


              $UPDATE =  " insert into fines (loan_id,fine_amt)
              (select A.loan_id, A.due
              from (SELECT loan_id, 0.25 * datediff(now(),due_date) as due from book_loans where loan_id = 
              '$loan') as A
              where A.due > 0)";
             $UPDATE_STATUS= $db->query($UPDATE);

          echo '<script language="javascript">';
          echo 'alert("Check - In Done Successfully")';
          echo '</script>';
          }

        $sql="SELECT  L.LOAN_ID,L.due_date, B.TITLE, B.ISBN13, BW.CARD_ID, BW.SSN, CONCAT(first_name,' ',last_name) AS BNAME
        FROM BOOK B, BOOK_LOANS L, BORROWER BW 
        WHERE (
                  (B.TITLE LIKE '%" . $search . "%' OR B.ISBN13 LIKE '" . $search . "')  OR
                  (BW.SSN LIKE '" . $search . "' OR  BW.CARD_ID LIKE '" . $search . "' OR BW.first_name LIKE '%" . $search . "%') OR
                   (L.LOAN_ID LIKE '" . $search . "')
              ) AND
                 (B.ISBN13 = L.ISBN13 AND L.CARD_ID = BW.CARD_ID) AND (L.DUE_DATE IS NOT NULL AND L.DATE_IN IS NULL) "; 
        //-run  the query against the mysql query function 
        $result= $db->query($sql); 
        //-create  while loop and loop through result set 
      //  echo "YOOO";
        if($result->num_rows > 0){
          echo "done";
         
        



         
          echo"<div style='overflow-x:auto;'>
          <table>
          <tr>
              <th>LOAN_ID</th>
              <th>Book Name</th>
              <th>ISBN13</th>
              <th>NAME</th>
              <th>CARD_ID</th>
              <th>SSN</th>
              <th>Due Date</th>
              <th>Over Due ?</th>
          </tr>";
          while($rows = $result->fetch_assoc()){ 

            $BOOKNAME  =$rows['TITLE']; 
            $ISBN=$rows['ISBN13']; 
            $BORROWER_ID=$rows['CARD_ID'];
            $BNAME = $rows['BNAME'];
            $SSN = $rows['SSN'];
            $LOAN_ID = $rows['LOAN_ID'];
            $DUE_DATE = $rows['due_date'];
            $unix_time = strtotime($DUE_DATE); 
          //  echo "fuckkkkkk";

            $fine_update = "SELECT count(loan_id) as count,datediff(now(),due_date) as days from book_loans where loan_id = '$LOAN_ID' ";
            $result_status= $db->query($fine_update); 
            $row1 = mysqli_fetch_array($result_status);
            echo "   
                <tr>
                  <td>".$LOAN_ID."</td>
                  <td>".$BOOKNAME."</td>
                  <td>" . $ISBN."</td>
                  <td>".$BNAME ."</td>
                  <td>".$BORROWER_ID ."</td>
                  <td>".$SSN."</td>
                  <td>     
                   
                  ".date('F j, Y, g:i a', $unix_time)."
                  </td> <td>";




              if($row1['days'] < 0){
                   echo "<b>NO</b>";
                  }
              else{

              echo "<b>YES</b>";
                  }  
              ?>

                      <form action='<?php echo $_SERVER['PHP_SELF']."?search=$search"; ?>' method= 'GET'>
                    <input type='hidden' name='loan_id' value='<?php echo $LOAN_ID; ?>'/>
                    <input type='hidden' name='search' value='<?php echo $search; ?>'/>
                     <input type='submit' name='check' value='Check In' class='button button2'/>
                     </form>
                
                  <?php 
               
                    }    
        echo "</td></tr>";  

        echo "</table> </div>";
        }
       else{ 
          echo  "<p>Please enter any details related to Loan: NO RESULTS FOUND</p>"; 
        } 
      } 
    else{
        echo "Type ISBN or TITLE or Author's name of the required book or SSN or borrower's ID  </b>";
    }
    ?>
  

  </div>


</body>
</body>
</html>