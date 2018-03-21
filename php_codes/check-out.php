<?php include "head.php"; ?>
<h1>Check-Out</h1>
<?php
    include "connect.php";
    
    if(empty($_POST) == false  && ( $_GET['id']!=NULL || $_POST['id']!= NULL) ) 
    {    
        if($_GET['id']!=NULL){
            $ISBN = $_GET['id'];
        }
        else if($_POST['id']!= NULL){
            $ISBN = $_POST['id'];
        }
        echo"<h5>Verify Book Details before Check-Out <h5>
            <div style='overflow-x:auto;'>
          <table>
      
          <tr>
              <th>Book Name</th>
              <th>Authors</th>
              <th>ISBN</th> 
          </tr>";
       // $ssn = $_POST['ssn'];
       
       echo $ISBN;
       $BOOK =  "SELECT  B.TITLE, B.ISBN13, A.NAME 
       FROM BOOK B,authors A, book_authors BA 
       WHERE B.ISBN13 = '{$ISBN}' AND B.ISBN13 = BA.ISBN13 AND BA.AUTHOR_ID = A.AUTHOR_ID";
       $result= $db->query($BOOK); 
       $row=mysqli_fetch_array($result);
       $TITLE  =$row['TITLE']; 
        $AUTHOR=$row['NAME']; 
        $ISBN=$row['ISBN13']; 
      echo" <tr>
                  <td>".$TITLE."</td>
                  <td>" . $AUTHOR ."</td>
                  <td>".$ISBN ."</td>
            </tr> </table></div><br>";
    }
    if(empty($_POST) == false && $_POST['card_id']!= NULL){


        echo $_POST['card_id']."<br>";
       // $ISBN = $_GET['id']."<br>";
       // echo $ISBN."<br>";
        $card_id = $_POST['card_id'];
       // echo $SSN."<br>";
        $sql1 = "SELECT count(ssn),card_id,ssn FROM BORROWER WHERE card_id = '$card_id' ";
        $result1 = $db->query($sql1);
        $row1 = mysqli_fetch_array($result1);
       // echo $row1['count(ssn)']."<br>";
       // echo $row1['ssn']."<br>";

        if($row1['count(ssn)'] > 0 ){   
                $id_bor = $row1['card_id'];
                $sql3 = "SELECT count(card_id) FROM book_loans WHERE card_id = '$id_bor' AND DATE_IN IS NULL";
                $result3 = $db->query($sql3);
                $row3 = mysqli_fetch_array($result3);
            if($row3['count(card_id)'] < 3){
                $BORROWER_ID = $row1['card_id'];

                $sql3 = "SELECT count(card_id) from book_loans L where card_id = '$BORROWER_ID' and datediff(now(),due_date) > 0";
                $result3 = $db->query($sql3);
                $row3 = mysqli_fetch_array($result3);
                $due_check = $row3['count(card_id)'];
                echo $due_check;
                $sql2 = "SELECT count(card_id) 
                FROM book_loans B,FINES F 
                WHERE card_id = '$BORROWER_ID' AND  F.LOAN_ID = B.LOAN_ID AND F.PAID = 0";
                $result2 = $db->query($sql2);
                $row2 = mysqli_fetch_array($result2);
                $fine_check = $row2['count(card_id)'];



                if($fine_check == 0){

                    if($due_check == 0){

                     $duplicate = "SELECT count(isbn13) as count
                                            from book_loans
                                            where DATE_IN IS NULL
                                            AND isbn13 = '{$ISBN}'
                                        ";
                        $result_dup = $db->query($duplicate);
                        $multiple  = mysqli_fetch_array($result_dup);
                        //  echo  $multiple['count'];
                  
                        if($multiple['count'] == 0){

                        $LOAN = "INSERT INTO book_loans
                            (isbn13,card_id,date_out,due_date)
                        VALUES ('{$ISBN}','{$BORROWER_ID}',now(),DATE_ADD(now(),INTERVAL 14 DAY))";
                        $result_status= $db->query($fine_check); 
                        $rowfine = mysqli_fetch_array($result_status);

                        if ($db->query($LOAN) === TRUE) {
                        
                            echo '<script language="javascript">';
                            echo 'alert("Check - Out Done Successfully")';
                            echo '</script>';
                            header("Location: http://localhost:8888/Search/index.php");
                            die();
                            //  echo "done";
                        }
                        else {
                            echo " Error: <br>" . $db->error;       
                        }

                        }

                        else{

                            echo '<script language="javascript">';
                        
                            echo 'alert("Book was Already Taken")';
                            echo '</script>';

                            header("Location: http://localhost:8888/Search/index.php");
                            die();

                    }
                    }
                    else{
                        echo '<script language="javascript">';
                        
                            echo 'alert("Borrower have Due Book/s")';
                            echo '</script>';
                    }
                }    
                else{
                    echo '<script language="javascript">';
                echo 'alert("Borrower have dues to pay")';
                echo '</script>';
                }
            }
            else{
                echo '<script language="javascript">';
                echo 'alert("Borrower can not take more than 3 BOOKS")';
                echo '</script>';
            }
        } 
        else{
           header("Location: http://localhost:8888/Search/Borrower/new_borrower.php");
           echo '<script language="javascript">';
           echo 'alert("Borrower Record Not Found")';
           echo '</script>';
        }
    }

?>
 <SCRIPT LANGUAGE="JavaScript">
function addDashes(f)
{
    if(f.value.length == 9){
        f.value = f.value.slice(0,3)+"-"+f.value.slice(3,5)+"-"+f.value.slice(5,9);
    }
}
</SCRIPT>
        <br><br><div class='form1'>
            <form action='<?php echo $_SERVER['PHP_SELF']."?id=$ISBN"; ?>' method= 'POST'>

            <label for= 'ssn'>    CARD ID  (Enter CARD ID to Check-Out with your Account)</label><br>
            <input  class= 'ssn' type= 'text' style= 'font-size:25px ;font-weight: bold;'' id= 'card_id' name= 'card_id' required  ><br>

            <input class= 'button button2' align= 'center'  type= 'submit' value= 'Check-Out'> 
            </form>
        </div> 

</body>
</html>
