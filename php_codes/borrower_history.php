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
      //  echo $search ;
        }
        else{
          $search = $_GET['search'];
         // echo $search;
         // echo "yooo";
        }


        //$search = "";
        echo "<br>Results for Search Text: <b> $search </b><br>";

        
        $sql_details = "SELECT CARD_ID, CONCAT(first_name,' ',last_name) AS BNAME
        FROM BORROWER BW
        WHERE ( BW.CARD_ID LIKE '" . $search . "')";
        $card_details= $db->query($sql_details);
        $row21 = mysqli_fetch_array($card_details);
        if($card_details->num_rows > 0){   
           echo"<br><b>Borrower's Name  :".$row21['BNAME']."</b><br> <b>Borrower's CARD ID :".$row21['CARD_ID']."</b><br>";

          $sql="SELECT  L.LOAN_ID,L.due_date, B.TITLE, B.ISBN13, BW.CARD_ID, L.date_in,L.date_out
          FROM BOOK B, BOOK_LOANS L, BORROWER BW 
          WHERE ( BW.CARD_ID LIKE '" . $search . "') AND
          (B.ISBN13 = L.ISBN13 AND L.CARD_ID = BW.CARD_ID) "; 
          //-run  the query against the mysql query function 
          $result= $db->query($sql); 
          //-create  while loop and loop through result set 
          //  echo "YOOO";
            if($result->num_rows > 0){   
                echo"<div style='overflow-x:auto;'>
                <table>
                <caption>".$row21['BNAME']."'s History<caption>
                <tr>
                  <th>LOAN_ID</th>
                  <th>Book Name</th>
                  <th>ISBN13</th>
                  <th>Date Out</th>
                  <th>Due Date</th>
                  <th>Date In</th>
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
             $DATE_IN = $rows['date_in'];
             $DATE_OUT = $rows['date_out'];
            $unix_time_in = strtotime($DATE_IN);
            $unix_time_out = strtotime($DATE_OUT);
            

            $fine_update = "SELECT count(loan_id) as count,datediff(now(),due_date) as days from book_loans where loan_id = '$LOAN_ID' ";
            $result_status= $db->query($fine_update); 
            $row1 = mysqli_fetch_array($result_status);
            echo "   
                <tr>
                  <td>".$LOAN_ID."</td>
                  <td>".$BOOKNAME."</td>
                  <td>" . $ISBN."</td><td>
                 ".date('F j, Y, g:i a', $unix_time_out)."
                  </td>
                  <td>     
                   
                  ".date('F j, Y, g:i a', $unix_time)."
                  </td>";

            if(is_null($DATE_IN)){
                    echo "<td>Yet to Submit</td>";
               }
            else{
                  echo "<td>".date('F j, Y, g:i a', $unix_time_in)."</td>";}
            }
            echo "</tr></table> </div>";
        
      }
      else{ 
         
        echo  "<p>NO HISTORY</p>";
        }
    }
       else{ 
             echo  "<p>Please enter any details related to borrower: INVALID CARD_ID</p>";
        } 
      } 
    else{
        echo "Type borrower's ID  </b>";
    }
    ?>
  

  </div>


</body>
</body>
</html>