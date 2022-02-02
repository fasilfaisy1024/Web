<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$db = mysqli_connect('localhost', 'root', '', 'web');


$create_table_qry = "create table if not exists books (book_id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,   accession_no varchar(20) NOT NULL,book_title varchar(50) NOT NULL,book_author varchar(20) NOT NULL,edition varchar(20) NOT NULL,publisher varchar(20) NOT NULL)";

$create_table = mysqli_query($db, $create_table_qry);

$err_msg = $succ_msg = '';



if (isset($_POST['add_book'])) {
    $accession_no = $_POST['accession_no'];
    $book_title = $_POST['book_title'];
    $book_author = $_POST['book_author'];
    $edition = $_POST['edition'];
    $publisher = $_POST['publisher'];

    $err_msg .= (!preg_match('/^[a-zA-Z][A-Za-z\s]*[a-zA-Z]$/', $book_title)) ? '<p>Book name should contain alphabets only</p>' : '';
    $err_msg .= (!preg_match('/^[a-zA-Z][A-Za-z\s]*[a-zA-Z]$/', $book_author)) ? '<p>Author name should contain alphabets only</p>' : '';

    if (strlen($err_msg) == 0) {
        $insert_book = "insert into books (accession_no, book_title,book_author, edition,publisher) VALUES ('$accession_no','$book_title','$book_author','$edition','$publisher')";
        $insert_result = mysqli_query($db, $insert_book);

        if ($insert_result)
            echo "<script>alert('Successfully added book')</script>";
        else
            echo "<script>alert('Could not add book')</script>";
    }
}


if (isset($_POST['search_book'])) {
    $books_qry = "select * from books where book_title like '%$_POST[book_title]%'";
    $books_records = mysqli_query($db, $books_qry);
}


?>

<title>Book store</title>

<body>

    <center>
        <h2>Book Details</h2>
    </center>

    <div class="container" style="width: 45%;margin: 30px auto;">
     <div>
       <?php if (strlen($err_msg > 0)) : ?>


        <div class="alert alert-error">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            <?= $err_msg ?>
        </div>


    <?php endif; ?>

    <form method="post" style="margin: 0px 10px;">
        <label for="fname">Accession no</label>
        <input type="text" id="accession_no" name="accession_no" required>



        <label for="lname">Book title</label>
        <input type="text" id="book_title" name="book_title" required>


        <label for="lname">Book author</label>
        <input type="text" id="book_author" name="book_author" required>


        <label for="lname">Edition</label>
        <input type="text" id="edition" name="edition" required>


        <label for="lname">Publisher name</label>
        <input type="text" id="publisher" name="publisher" required>




        <input type="submit" style="display:  block;margin: 10px auto;" name="add_book" value="Add">
    </form>
</div>

</div>
<div class="container" style="width: 60%;margin: 30px auto;">

    <div>

        <form method="post">
            <input type="text" name="book_title" id="book_title" placeholder="Enter bookname to search ..." style="width: 84%">
            <input type="submit" name="search_book" value="Search" style="width: 15%;">
        </form>

        <?php if (isset($_POST['search_book'])) {
            ?>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Accession no</th>
                        <th>Book title</th>
                        <th>Author</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1;
                    while ($books = mysqli_fetch_array($books_records)) {
                        ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><?= $books['accession_no'] ?></td>
                            <td><?= $books['book_title'] ?></td>
                            <td><?= $books['book_author'] ?></td>

                        </tr>
                    <?php }  ?>
                </tbody>
            </table>
        <?php } ?>
    </div>





</div>
</body>



<style>
    table {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    table td,
    table th {
        border: 1px solid #ddd;
        padding: 8px;
    }


    table tr:hover {
        background-color: #ddd;
    }

    table th {
        padding-top: 12px;
        padding-bottom: 12px;
    }



    input[type=text],
    input[type=date],
    input[type=time],
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

    input[name=search_book] {
        background-color: #46a7f5 !important;
    }

    input[type=submit] {
        width: 20%;
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