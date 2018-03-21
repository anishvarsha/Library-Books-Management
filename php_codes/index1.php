<!doctype html>
<html lang="en">
<head>


<style>

body {margin:0;}

ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
    background-color: #333;
    position: fixed;
    top: 0;
    width: 100%;
}

li {
    float: left;
}

li a {
    display: block;
    color: white;
    padding: 16px;
    text-decoration: none;
}

.main {
    padding: 16px;
    margin-top: 30px;
    height: 1500px; /* Used in this example to enable scrolling */
}

table {
    border-collapse: collapse;
    border-spacing: 0;
    width: 100%;
    border: 1px solid #ddd;
}

th, td {
    border: none;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even){background-color: #f2f2f2}


input[type=text] {
    width: 500px;
    box-sizing: border-box;
    border: 2px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
    background-color: white;
    background-image: url('search.png');
    background-position: 10px 10px;
    background-repeat: no-repeat;
    padding: 12px 20px 12px 40px;
    -webkit-transition: width 0.4s ease-in-out;
    transition: width 0.4s ease-in-out;
}

input[type=text]:focus {
    width: 90%;
}
</style>



  <meta charset="utf-8">
  <title>Project 1</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <script>
  $(function() {
    $( "#search" ).autocomplete({
      source: 'search_suggesion.php'
    });
  });
  </script>
</head>
<body>

<ul>
  <li><a href="index.php">Home</a></li>
  <li><a href="#news">News</a></li>
  <li><a href="#contact">Contact</a></li>
</ul>

<div class="main">
 <br>
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post"  >
   <input type="text" name="search" placeholder="Search (Book Name or Author's Name or ISBN)" id ="search"  />
    <input type="submit" name="submit" value="search" />
  </form>
  <?php
    if(isset($_POST['search']) && $_POST['search'] != NULL) 
      { 
        $search = $_POST['search'];
        include "connect.php";
        //$search = "";
        echo "<br><br>Results for Search: <b> $search </b>";

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
              <th>ISBN</th>
              <th>ISBN</th>
          </tr>";
      while($rows = $result->fetch_assoc()){ 
            $TITLE  =$rows['TITLE']; 
            $AUTHOR=$rows['AUTHOR']; 
            $ISBN=$rows['ISBN13'];
            //-display the result of the array 
            echo"   
                <tr>
                  <td>".$TITLE."</td>
                  <td>" . $AUTHOR ."</td>
                  <td>".$ISBN ."</td>
                  <td>Not yet wrote</td>
                </tr> 
                ";  
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