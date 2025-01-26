<nav class="navtop">
	<div class="container">
		<div class="d-flex align-items-center justify-content-between">
			<a href="home.php">
				<img src="logo.png" alt="logo" class="logo" />
			</a>
			<div>
				<a class="navtopLink mr-3" href="profile.php"><i class="mr-1 fa-solid fa-user"></i>Profil</a>
				<a class="navtopLink" href="logout.php"><i class="mr-1 fas fa-sign-out-alt"></i>Logout</a>
			</div>
		</div>
	</div>
</nav>
<style>
	.navtop {
		position: sticky;
		background-color: #05212a;
		height: 60px;
		width: 100%;
		border: 0;
	}

	.navtopLink {
		color: white;

		&:hover {
			color: white;
		}
	}

	.logo {
		height: 60px;
		width: 60px;
	}
</style>