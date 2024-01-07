<?php
require_once("./includes/functions.inc.php");
$error = false;
if (isset($_POST['action'])) {
    //you pressed submit button
    $first_name = sanitize($_POST['first_name']);
    $last_name = sanitize($_POST['last_name']);
    $email = sanitize($_POST['email']);
    $telephone = sanitize($_POST['telephone']);
    $address = sanitize($_POST['address']);
    $birthdate = sanitize($_POST['birthdate']) ? date("Y-m-d", strtotime(sanitize($_POST['birthdate']))) : "";

    if (
        !$first_name || !$last_name || !$email || !$telephone || !$address || !$birthdate ||
        !isset($_FILES['pic']['name'])
    ) {
        $error = true;
    } else {
        $og_file_name = $_FILES['pic']['name'];
        $ext = end(explode(".", $og_file_name));
        $tmp_path = $_FILES['pic']['tmp_name'];

        $data['first_name'] = $first_name;
        $data['last_name'] = $last_name;
        $data['email'] = $email;
        $data['telephone'] = $telephone;
        $data['address'] = $address;
        $data['birthdate'] = $birthdate;
        $data['image_name'] = $ext;
        $query = prepare_insert_query("contacts", $data);

        db_query($query);

        $contact_id = get_last_insert_id();

        move_uploaded_file($tmp_path, "images/users/$contact_id.$ext");

        redirect("index.php?op=insert&status=success");
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection" />

    <!--Import Csutom CSS-->
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Add Contact</title>
</head>

<body>
    <?php
    include_once("./includes/navbar.inc.php");
    ?>

    <div class="container">
        <div class="row mt50">
            <h2>Add New Contact</h2>
        </div>
        <?php
        if ($error) :
        ?>
            <div class="row">
                <div class="materialert error">
                    <!-- ye ek baar demo karke dekhna -->
                    <div class="material-icons">error_outline</div>
                    Oh Snap! Some Error Occurred at server side !
                    <button type="button" class="close-alert">×</button>
                </div>
            </div>
        <?php
        endif;
        ?>
        <div class="row">
            <form class="col s12 formValidate" action="" id="add-contact-form" method="POST" enctype="multipart/form-data">
                <div class="row mb10">
                    <div class="input-field col s6">
                        <input id="first_name" name="first_name" type="text" class="validate" data-error=".first_name_error">
                        <label for="first_name">First Name</label>
                        <div class="first_name_error "><?= isset($first_name) && empty($first_name) ?
                                                            "Please Fill" : " " ?></div>
                    </div>
                    <div class="input-field col s6">
                        <input id="last_name" name="last_name" type="text" class="validate" data-error=".last_name_error">
                        <label for="last_name">Last Name</label>
                        <div class="last_name_error "><?= isset($last_name) && empty($last_name) ?
                                                            "Please Fill" : " " ?></div>
                    </div>
                </div>
                <div class="row mb10">
                    <div class="input-field col s6">
                        <input id="email" name="email" type="email" class="validate" data-error=".email_error"><?= isset($email) && empty($email) ?
                                                                                                                    "Please Fill" : " " ?>
                        <label for="email">Email</label>
                        <div class="email_error "></div>
                    </div>
                    <div class="input-field col s6">
                        <input id="birthdate" name="birthdate" type="text" class="datepicker" data-error=".birthday_error">
                        <label for="birthdate">Birthdate</label>
                        <div class="birthday_error ">
                            <?= isset($birthdate) && empty($birthdate) ?
                                "Please Fill" : " " ?>
                        </div>
                    </div>
                </div>
                <div class="row mb10">
                    <div class="input-field col s12">
                        <input id="telephone" name="telephone" type="tel" class="validate" data-error=".telephone_error">
                        <label for="telephone">Telephone</label>
                        <div class="telephone_error "><?= isset($telephone) && empty($telephone) ?
                                                            "Please Fill" : " " ?></div>
                    </div>
                </div>
                <div class="row mb10">
                    <div class="input-field col s12">
                        <textarea id="address" name="address" class="materialize-textarea" data-error=".address_error"></textarea>
                        <label for="address">Address</label>
                        <div class="address_error "><?= isset($address) && empty($address) ?
                                                        "Please Fill" : " " ?></div>
                    </div>
                </div>
                <div class="row mb10">
                    <div class="file-field input-field col s12">
                        <div class="btn">
                            <span>Image</span>
                            <input type="file" name="pic" id="pic" data-error=".pic_error">
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text" placeholder="Upload Your Image">
                        </div>
                        <div class="pic_error "></div>
                    </div>
                </div>
                <button class="btn waves-effect waves-light right" type="submit" name="action">Submit
                    <i class="material-icons right">send</i>
                </button>
            </form>
        </div>
    </div>
    <footer class="page-footer p0">
        <div class="footer-copyright ">
            <div class="container">
                <p class="center-align">© 2020 Study Link Classes</p>
            </div>
        </div>
    </footer>
    <!--JQuery Library-->
    <script src="js/jquery.min.js" type="text/javascript"></script>
    <!--JavaScript at end of body for optimized loading-->
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <!--JQuery Validation Plugin-->
    <script src="vendors/jquery-validation/validation.min.js" type="text/javascript"></script>
    <script src="vendors/jquery-validation/additional-methods.min.js" type="text/javascript"></script>
    <!--Include Page Level Scripts-->
    <script src="js/pages/add-contact.js"></script>
    <!--Custom JS-->
    <script src="js/custom.js" type="text/javascript"></script>
</body>

</html>