<form action="/user/login-submit" method="post">
	<div class="form-group">
	    <label for="email">Email address</label>
	    <input type="email" name="email" class="form-control" id="email" placeholder="Enter email">
	</div>
	<div class="form-group">
	    <label for="password">Password</label>
	    <input type="password" name="password" class="form-control" id="password" placeholder="Password">
	</div>
	<div class="form-group form-check">
	    <input type="checkbox" class="form-check-input" name="remember" id="remember">
	    <label class="form-check-label" for="remember">Remember me</label>
	</div>
	<button type="submit" class="btn btn-primary">Login</button>
</form>