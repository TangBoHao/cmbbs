<?php

/*用户注册页面*/

require('../config/config.inc.php');
include('../config/header.inc.php');
header("Content-type:text/html;charset=utf-8");
?>
<div class="h3">用户注册</div><br><br>	

<!-- <legend>Goblin用户登录</legend> -->
<form action="add_user.php" method="post" role="form" class="form-horizontal">
		<div class="form-group" form-group-lg>
			<label for="username" class="col-sm-1 control=label">Username</label>
			<div class="col-sm-4">
				<input type="text" class="form-control" id="username" name="username" placeholder="Enter your username">
			</div>
		</div>
		<div class="form-group" form-group-sm>
			<label for="password" class="col-sm-1 control=label">Password</label>
			<div class="col-sm-4">
				<input type="password" class="form-control" id="password" name="password" placeholder="Enter your password">
			</div>
		</div>
		<div class="form-group" form-group-sm>
			<label for="email" class="col-sm-1 control=label">Email</label>
			<div class="col-sm-4">
				<input type="text" class="form-control" id="email" name="email" placeholder="Enter your email">
			</div>
		</div>
		<div class="form-group" form-group-sm>
			<label for="realname" class="col-sm-1 control=label">Realname</label>
			<div class="col-sm-4">
				<input type="text" class="form-control" id="realname" name="realname" placeholder="Enter your realname">
			</div>
		</div>
		<div class="form-group">
			<!-- <div class="col-sm-offset-2 col-sm-1">
				<input type="reset" class="btn btn-primary" value="Reset" name="reset">
			</div> -->
			<div class="col-sm-offset-2 col-sm-3">
				<input type="reset" class="btn btn-default" value="Reset" name="reset">
				<input type="submit" class="btn btn-primary" value="Register" name="submit">
			</div>
		</div>
</form>

 <?php
//引入公用尾部
include('../config/footer.inc.php');
 ?>