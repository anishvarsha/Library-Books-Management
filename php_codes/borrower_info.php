<?php include "head.php"; ?>
<div >
 <br>
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post"  >
   <input class = "search" type="text" name="search" placeholder="Search (Book Name or Author's Name or ISBN)" id ="search"  />
    <input class="button"  type="submit" name="search1" />
  </form>
  <?php
    if(isset($_POST['search']) && $_POST['search'] != NULL) 
      { 
        $search = $_POST['search'];
        include "connect.php";
        //$search = "";
        echo "<br><br>Results for Search Text: <b> $search </b>";

        $sql="SELECT  TITLE,AUTHOR,ISBN13 FROM BOOKS WHERE TITLE LIKE '%" . $search . "%' OR AUTHOR LIKE '%" . $search . "%' OR ISBN13 LIKE '%" . $search . "%' "; 
        //-run  the query against the mysql query function 
        $result= $db->query($sql); 
        //-create  while loop and loop through result set 
  
        if($result->num_rows > 0){
          echo"<div style='overflow-x:auto;'>
          <table>
          <tr>
              <th>Book Name</th>
              <th>Authors</th>
              <th>ISBN</th>
              <th>Availability Status</th>
              <th>Check</th>
              <th></th>
          </tr>";
          while($rows = $result->fetch_assoc()){ 
            $TITLE  =$rows['TITLE']; 
            $AUTHOR=$rows['AUTHOR']; 
            $ISBN=$rows['ISBN13'];
            $status = "SELECT count(ISBN13) FROM BOOK_LOANS WHERE ISBN13 = '{$ISBN}' ";
            $result_status= $db->query($status); 
            $row1 = mysqli_fetch_array($result_status);

            if($row1['count(ISBN13)'] < 1){
                $Availability = "YES";

                $check = 1;
            }
            else{
                $Availability = "NO";
                $check = 0;
            }
            //-display the result of the array 
            echo "   
                <tr>
                  <td>".$TITLE."</td>
                  <td>" . $AUTHOR ."</td>
                  <td>".$ISBN ."</td>
                  <td>".$Availability."</td>";
                  if($check == 1){
                   echo " <td><a href='check_out.php'><button class='button button2'>Check-Out</button></a></td>";
                  }
               
          echo "</tr>";  
          }    
    
        echo "</table> </div>";
        }
       else{ 
          echo  "<p>Please enter a search query</p>"; 
        } 
      } 
    else{
        echo "Type ISBN or TITLE or Author's name of the required book </b>";
    }
    ?>
  

  </div>


</body>
</body>
</html>