<?php
$this->load->view('authentication/header.php');
?>
<?php if($this->session->userdata('success_message')): ?>
<div class="alert alert-success">&#10004; <?php echo $this->session->userdata('success_message'); ?></div>
<?php endif; ?>

<?php if($this->session->userdata('error_message')): ?>
    <div class="alert alert-danger">&#x2718; <?php echo $this->session->userdata('error_message'); ?></div>
<?php endif; ?>

<div class="container">
<form method="post" action="">
    <div class="jumbotron" id="login-box">
        <h3>Login Here</h3>
    <label>Username</label>
        <input type="text" class="form-control" name="username" required="required">
        <label>Password</label>
        <input type="password" class="form-control" name="password" required="required"><br>
        <input type="submit" class="form-control btn btn-info" value="Login">
    </div>
</form>
</div>

<?php
$this->load->view('authentication/footer.php');
?>
<?php if($this->session->userdata('success_message')): ?>
<script>
    setInterval(function(){ window.location="<?php echo base_url('profile/employer'); ?>"; }, 3000);
</script>
<?php endif; ?>
<style>
    #login-box{
        width:50% !important;
        margin:auto;
        margin-top:150px;
    }

    .login{
        height:152px !important;
    }

    .alert{
        padding-left:200px;
    }
</style>
