<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$db = mysqli_connect('localhost', 'root', '', 'web');


$create_table_qry = "create table if not exists railway (ticket_id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,full_name varchar(20) NOT NULL,address varchar(50) NOT NULL,
    train_no varchar(10) NOT NULL,train_name varchar(15) NOT NULL,date_of_journey date NOT NULL,boarding_time time NOT NULL)";

$create_table = mysqli_query($db, $create_table_qry);

$err_msg = $succ_msg = '';



if (isset($_POST['book_ticket'])) {
    $full_name = $_POST['full_name'];
    $address = $_POST['address'];
    $train_no = $_POST['train_no'];
    $train_name = $_POST['train_name'];
    $date_of_journey = $_POST['date_of_journey'];
    $boarding_time = $_POST['boarding_time'];

    $err_msg .= (!preg_match('/^[a-zA-Z][A-Za-z\s]*[a-zA-Z]$/', $full_name)) ? '<p>Name should contain alphabets only</p>' : '';

    if (strlen($err_msg) == 0) {
        $insert_ticket = "insert into railway (full_name, address,train_no, train_name,date_of_journey,boarding_time) values ('$full_name','$address','$train_no','$train_name','$date_of_journey','$boarding_time')";
        $insert_result = mysqli_query($db, $insert_ticket);

        if ($insert_result)
            echo "<script>alert('Successfully booked ticket')</script>";
        else
            echo "<script>alert('Could not book ticket')</script>";
    }
}



$tickets_qry = "select * from railway";
$tickets_records = mysqli_query($db, $tickets_qry);



?>
<html>
<head>
    <title>Railway Ticket Booking</title>
</head>
<body>

    <center><h2>Railway Ticket Booking</h2></center>
    <div class="container" style="width: 45%;margin: 30px auto;">
        <div>



            <?php if (strlen($err_msg > 0)) : ?>


                <div class="alert alert-error">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                    <?= $err_msg ?>
                </div>


            <?php endif; ?>



            <form method="post" style="margin: 0px 10px;">
                <label for="fname">Full Name</label>
                <input type="text" id="full_name" name="full_name"  required>

                <label for="lname">Address</label>
                <textarea name="address" id="address" rows="5" required>
                </textarea>


                <label for="lname">Train Number</label>
                <input type="number" id="train_no" name="train_no" >


                <label for="lname">Train Name</label>
                <input type="text" id="train_name" name="train_name" required>


                <label for="lname">Date of journey</label>
                <input type="date" id="date_of_journey" name="date_of_journey" required>


                <label for="lname">Time of boarding</label>
                <input type="time" id="boarding_time" name="boarding_time" required>

                <input type="submit" style="display:  block;margin: 10px auto;"  name="book_ticket" value="Book Now">
            </form>
        </div>

    </div>

    <div class="container" style="width: 60%;margin: 30px auto;">

        <div>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Train Number</th>
                        <th>Boarding time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1;
                    while ($tickets = mysqli_fetch_array($tickets_records)) {
                        ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><?= $tickets['full_name'] ?></td>
                            <td><?= $tickets['train_name'] ?></td>
                            <td><?= $tickets['boarding_time'] ?></td>

                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>





    </div>
</body>



<style>

    table {
      font-family: Arial, Helvetica, sans-serif;
      border-collapse: collapse;
      width: 100%;
  }

  table td, table th {
      border: 1px solid #ddd;
      padding: 8px;
  }


  table tr:hover {background-color: #ddd;}

  table th {
      padding-top: 12px;
      padding-bottom: 12px;
      text-align: left;
  }



  input[type=text],
  input[type=date],
  input[type=time],
  input[type=number],
  textarea,
  select {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

input[name=show_tickets] {
    background-color: #46a7f5 !important;
}

input[type=submit] {
    width: 20   %;
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

input[type=submit]:hover {
    background-color: #45a049;
}

div {
    border-radius: 5px;
    background-color: #f2f2f2;
    padding: 20px;
}

.col-3 {
    width: 50%;
}

.alert {
    padding: 20px;
    background-color: #f44336;
    color: #fff;
    margin-bottom: 2%;
}

.alert-error {
    background-color: #f44336;
}

.alert-success {
    background-color: #2eb885;
}

.closebtn {
    margin-left: 15px;
    color: white;
    font-weight: bold;
    float: right;
    font-size: 22px;
    line-height: 20px;
    cursor: pointer;
    transition: 0.3s;
}

.closebtn:hover {
    color: black;
}
</style>
</html>