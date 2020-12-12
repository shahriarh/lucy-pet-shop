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
		  <a class="navbar-brand" href="#">
			<span><img alt="Brand" src="favicon.png" style="height: 20px;"></span> Lucy's Pet Shop
		  </a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a href="#">Home</a></li>
        <li><a href="pets.php">My Pets</a></li>
		<?php if (isset ($_SESSION['login']) && $_SESSION['admin'] == true): ?>
			<li><a href="services.php">Manage Services</a></li>
		<?php endif; ?>
      </ul>
      <ul class="nav navbar-nav navbar-right">
		<?php if (isset ($_SESSION['login'])): ?>
			<li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout [<?=$_SESSION['name'] ?>]</a></li>
		<?php endif; ?>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>