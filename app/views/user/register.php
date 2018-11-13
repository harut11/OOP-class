<form method="post" action="/user/register-submit">
	<div class="form-group">
	    <label for="first_name">First Name</label>
	    <input type="text" name="first_name" class="form-control" id="first_name" placeholder="Your First Name">
	</div>
	<div class="form-group">
	    <label for="last_name">Last Name</label>
	    <input type="text" name="last_name" class="form-control" id="last_name" placeholder="Your Last Name">
	</div>
	<div class="form-group">
	    <label for="email">Email address</label>
	    <input type="email" name="email" class="form-control" id="email" placeholder="Enter email">
	</div>
	<div class="form-group">
	    <label for="password">Password</label>
	    <input type="password" name="password" class="form-control" id="password" placeholder="Password">
	</div>
	<div class="form-group">
	    <label for="conf_password">Confirm Password</label>
	    <input type="password" name="confirm_password" class="form-control" id="confirm_password" placeholder="Confirm Your Password">
	</div>
	<button type="submit" class="btn btn-success">Register</button>
</form>