<!DOCTYPE html>
<html>
<?php
require_once('./includes/functions.inc.php');
// $query = "SELECT * FROM contacts";
// $rows = db_select($query);
$page = 1;
if (isset($_GET['page']))
    $page = $_GET['page'];

$num_of_rows_per_page = 4;
/*
page 1 = 0 ($pageNum-1) * num_of_rows_per_page
page 2 = 4
page 3 = 8
*/
$query = "SELECT COUNT(*) as total_records FROM contacts";
$total_records = db_select($query)[0]['total_records'];

$num_of_pages = ceil($total_records / $num_of_rows_per_page);

$start_offset = ($page - 1) * $num_of_rows_per_page;
$query = "SELECT * FROM contacts LIMIT $start_offset,$num_of_rows_per_page";
$rows = db_select($query);
?>

<head>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection" />

    <!--Import Csutom CSS-->
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body>
    <?php
    include_once("./includes/navbar.inc.php");
    ?>

    <!-- Add a New Contact Link-->
    <div class="row mt50">
        <div class="col s12 right-align">
            <a class="btn waves-effect waves-light blue lighten-2" href="add-contact.php"><i class="material-icons left">add</i> Add
                New</a>
        </div>
    </div>
    <!-- /Add a New Contact Link-->

    <!-- Table of Contacts -->
    <div class="row">
        <div class="col s12">
            <table class="highlight centered">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Email ID</th>
                        <th>Date Of Birth</th>
                        <th>Phone Number</th>
                        <th>Address</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>

                <!-- Data Comes Dynamically (PHP) -->
                <tbody>
                    <?php
                    foreach ($rows as $row) :
                    ?>
                        <tr>
                            <td><img class="circle" src="images/users/<?= get_image_file_name($row['image_name'], $row['id']); ?>" alt="" width="100px"></td>
                            <td><?= $row['first_name'] . " " . $row['last_name']; ?></td>
                            <td><?= $row['email']; ?></td>
                            <td><?= $row['birthdate']; ?></td>
                            <td><?= $row['telephone']; ?></td>
                            <td><?= $row['address']; ?></td>
                            <td><a class="btn btn-floating green lighten-2"><i class="material-icons">edit</i></a></td>
                            <td><a class="btn btn-floating red lighten-2 modal-trigger" href="#deleteModal"><i class="material-icons">delete_forever</i></a>
                            </td>
                        </tr>
                    <?php
                    endforeach;
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- /Table of Contacts -->
    <!-- Pagination -->
    <div class="row">
        <div class="col s12">
            <ul class="pagination">
                <?php
                if ($page == 1) :
                ?>

                    <li class="disabled"><a href="#!"><i class="material-icons">chevron_left</i></a></li>
                <?php
                else :
                ?>
                    <li>
                        <a href="?page=<?= $page - 1; ?>"><i class="material-icons">chevron_left</i></a>
                    </li>
                <?php
                endif;
                ?>
                <?php
                for ($i = 1; $i <= $num_of_pages; $i++) :
                ?>
                    <li <?= $page == $i ? "class='active'" : '' ?>><a href="?page=<?= $i; ?>"><?= $i; ?></a>
                    </li>
                <?php
                endfor;
                ?>
                <?php
                if ($page == $num_of_pages) :
                ?>

                    <li class="disabled"><a href="#!"><i class="material-icons">chevron_right</i></a></li>
                <?php
                else :
                ?>
                    <li>
                        <a href="?page=<?= $page + 1; ?>"><i class="material-icons">chevron_right</i></a>
                    </li>
                <?php
                endif;
                ?>
            </ul>
        </div>
    </div>

    <!-- /Pagination -->
    <!-- Footer -->
    <footer class="page-footer p0">
        <div class="footer-copyright ">
            <div class="container">
                <p class="center-align">© 2020 Study Link Classes</p>
            </div>
        </div>
    </footer>
    <!-- /Footer -->
    <!-- Delete Modal Structure -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <h4>Delete Contact?</h4>
            <p>Are you sure you want to delete the record?</p>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close btn blue-grey lighten-2 waves-effect">Cancel</a>
            <a href="#!" class="modal-close btn waves-effect red lighten-2">Agree</a>
        </div>
    </div>
    <!-- /Delete Modal Structure -->
    <!--JQuery Library-->
    <script src="js/jquery.min.js" type="text/javascript"></script>
    <!--JavaScript at end of body for optimized loading-->
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <!--Include Page Level Scripts-->
    <script src="js/pages/home.js"></script>
    <!--Custom JS-->
    <script src="js/custom.js" type="text/javascript"></script>
</body>

</html>