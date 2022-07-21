<nav class="container-fluid header p-1">
	<div class="row">
        <div class="col-6 d-flex justify-content pt-2">
			<h1>
            	<a class="p-3" href="../family/index.php">Engineering Family</a>
			</h1>
</div>
		<div class="col-6 d-flex justify-content-end">
			<?php if (!isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"]): ?>
				<a class="pt-1 text-right temp-display" href="../login/register_form.php">Sign up</a>
				<p class="p-1 text-right temp-display"> / </p>
				<a class="pt-1 text-right temp-display" href="../login/login.php">Login</a>
			<?php elseif ($_SESSION['username'] == "123"): ?>
				<div class="p-2">Hello Supervisor <a href="../family/mainpage.php"><?php echo $_SESSION["username"]; ?></a>!</div>
				<a class="p-2" href="../login/logout.php">Logout</a>
			<?php else: ?>
				<div class="p-2">Hello <a href="../family/mainpage.php"><?php echo $_SESSION["username"]; ?></a>!</div>
				<a class="p-2" href="../login/logout.php">Logout</a>
			<?php endif; ?>
		</div>
		<div class="col-12 d-flex justify-content">
			<div id="top-area" class="p-1 temp-display">
				Time: 
				<span id="time"></span>
					Today's weather in:
					<select id="city">
						<option value="Los Angeles">Los Angeles</option>
					</select>
					<span id="weather-low"></span>° Min and
					<span id="weather-high"></span>° High, 
					<span id="sky"></span>. 
			</div>
		</div>
	</div>
</nav>

