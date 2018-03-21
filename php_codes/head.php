<!doctype html>
<html lang="en">
<head>


<style>

.button {
    background-color: #854caf;  
    border: none;
    color: white;
    padding: 10px 25px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
    font-size: 20px;
}
.button2 {font-size: 14px; padding: 5px 15px; margin: 2px 1px;}

div.scrollmenu {
    background-color: #854caf;
    overflow: auto;
    white-space: nowrap;
}

div.scrollmenu a {
    display: inline-block;
    color: white;
    text-align: center;
    padding: 60px;
    padding-bottom:14px;
    padding-top: 14px; 
    text-decoration: none;
    font-size: 25px;
}

div.scrollmenu a:hover {
    background-color: #777;
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

input.formsubmit {
    width: 90%;
    background-color: #854caf;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    border-radius: 4px;
    cursor: pointer;

}

input.search, select {
    width: 85%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    font-size: 25px;
}

input.search1, select {
    width: 45%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    font-size: 25px;
}
input.form {
    width: 100%;
    padding: 8px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    font-size:20px ;
    font-weight: bold;
}
input.ssn {
    width: 60%;
    padding: 8px 10px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}
div.form1 {
    border-radius: 5px;
    background-color: #f2f2f2;
    padding: 20px;
}
div.form2 {
     width: 50%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}
input.form:focus {
    border: 3px solid #555;
}


</style>


  <meta charset="utf-8">
  <title>Project 1</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
 
</head>
<body>
<div class="scrollmenu">
  <a href="index.php">Home</a>
  <a href="new_borrower.php">New Borrower</a>
  <a href="check_in.php">Check In</a>
  <a href="borrower_history.php">Borrower History</a>
 <a href="fines.php">Fines Management</a>
</div>
