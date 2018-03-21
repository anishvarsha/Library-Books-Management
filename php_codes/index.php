<?php include "head.php"; ?>
 <script>
  $(function() {
    $( "#search" ).autocomplete({
      source: 'search_suggesion.php'
    });
  });
  </script>
<div >
 <br>
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post"  >
   <input class = "search" type="text" name="search" placeholder="Search (Book Name or Author's Name or ISBN)" id ="search"  />
   
    <input class="button"  type="submit" name="search1" />
  </form>
  <?php
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
        include "connect.php";
        //$search = "";
        echo "<br><br>Results for Search: <b> $search </b>";

        $sql="SELECT DISTINCT B.ISBN13, B.TITLE FROM BOOK B,authors A, book_authors BA WHERE (B.TITLE LIKE '%" . $search . "%' OR A.NAME LIKE '%" . $search . "%' OR B.ISBN13 LIKE '%" . $search . "%') AND B.ISBN13 = BA.ISBN13 AND BA.AUTHOR_ID = A.AUTHOR_ID"; 
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
             
            $ISBN=$rows['ISBN13'];
          //  echo $ISBN;
          //  echo "fuck";

            $author_set = " SELECT GROUP_CONCAT(name SEPARATOR ', ') as AUTHORS FROM book_authors ba,authors a where a.author_id = ba.author_id and isbn13 = '{$ISBN}' GROUP BY isbn13";

            $result_authors= $db->query($author_set); 

            $author_row = mysqli_fetch_array($result_authors);
          //  echo $author_row['AUTHORS'];

            $AUTHOR = $author_row['AUTHORS'];

            $status = "SELECT count(ISBN13) FROM BOOK_LOANS WHERE ISBN13 = '{$ISBN}' AND DATE_IN IS NULL AND DUE_DATE IS NOT NULL ";
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
                   echo " <td>

                     <form method='POST' action='check-out.php?'>
                    <input type='submit' name='flag' value='Check-Out' class='button button2'/>
                    <input type='hidden' name='id' value='$ISBN'/>
                     </form>
                
                    </td>";
                  }
                  else{
                   echo "<td>Unavailable</td>";
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