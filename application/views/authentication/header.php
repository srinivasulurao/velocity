<html>
<head>
    <title><?php echo $title; ?></title>
    <!--Core Bootsrap JS starts Here -->
    <script src="<?php echo base_url("assets/css/bootstrap.js"); ?>"> </script>
    <script src="<?php echo base_url("assets/css/npm.js"); ?>"> </script>
    <script src="<?php echo base_url("assets/css/velocity.js"); ?>"> </script>

    <!-- Core Bootstrap Css Starts Here- -->
    <link href="<?php echo base_url("assets/css/bootstrap.css"); ?>" rel="stylesheet">
    <link href="<?php echo base_url("assets/css/bootstrap-theme.css"); ?>" rel="stylesheet">
    <link href="<?php echo base_url("assets/css/velocity.css"); ?>" rel="stylesheet">
</head>

<header class="authentication-header login">
<div class="before-nav">
    <div class="col-md-1"></div>
    <div class="col-sm-2">
        <a href="<?php echo base_url(); ?>" style="text-decoration:none"><h1 class="logo">Velocity</h1></a>
    </div>
    <div class="col-sm-7" style="height:100px;"></div>
</div>
<div style="clear:both"></div>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li><a href="<?php echo base_url("authentication/aboutUs");?>">About Us</a></li>
                        <li><a href="<?php echo base_url("authentication/login");?>">Login</a></li>
                        <li><a href="<?php echo base_url("authentication/register");?>">Register</a></li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
</header>

<body>
</body>

</html>
