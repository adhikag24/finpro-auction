<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Forgot Password Finpro Auction</title>

    <!-- Font Icon -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/style.css?<?php echo date('l jS \of F Y h:i:s A'); ?>">
    <!-- Latest compiled and minified CSS -->
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- Main css -->
</head>

<body>

    <div id="login">
        <h3 class="text-center text-white pt-5">Forgot Password</h3>
        <div class="container">

            <div id="login-row" class="row justify-content-center align-items-center">
                
                <div id="login-column" class="col-md-6">
                    <div id="login-box" class="col-md-12">
                        <form id="login-form" class="form" action="<?= base_url() ?>auth/forgot_password_process" method="post">
                            <h3 class="text-center text-info">Forgot Password</h3>
                            <?= $this->session->flashdata('message'); ?>

                            <div class="form-group">
                                <label for="email" class="text-info">Email:</label><br>
                                <input type="text" name="email" id="email" class="form-control">
                                <?= form_error('email', '<small class="text-danger pl-3">', '</small>') ?>
                            </div>
                            <div class="form-group">
                                <label for="password" class="text-info">New Password:</label><br>
                                <input type="password" name="password" id="password" class="form-control">
                                <?= form_error('password', '<small class="text-danger pl-3">', '</small>') ?>
                            </div>
                            <div class="form-group">
                                <input type="submit" name="submit" class="btn btn-info btn-md" value="submit">
                            </div>
                            <div id="register-link" class="text-right">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- JS -->
</body><!-- This templates was made by Colorlib (https://colorlib.com) -->

</html>