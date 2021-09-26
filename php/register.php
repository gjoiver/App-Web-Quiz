<?php
	include("database.php");
	session_start();
	
	if(isset($_POST['submit']))
	{	
		$name = $_POST['name'];
		$name = stripslashes($name);
		$name = addslashes($name);

		$email = $_POST['email'];
		$email = stripslashes($email);
		$email = addslashes($email);

		$password = $_POST['password'];
		$password = stripslashes($password);
		$password = addslashes($password);

		
		$str="SELECT email from user WHERE email='$email'";
		$result=mysqli_query($con,$str);
		
		if((mysqli_num_rows($result))>0)	
		{
			var_dump('Holaaa');
            echo "<center><h3><script>alert('Sorry.. This email is already registered !!');</script></h3></center>";
            header("refresh:0;url=/api/login");
        }
		else
		{
			var_dump('Holaaa22');
            $str="insert into user set name='$name',email='$email',password='$password'";
			if((mysqli_query($con,$str)))	
			echo "<center><h3><script>alert('Congrats.. You have successfully registered !!');</script></h3></center>";
			header('location: /api/welcome');
		}
    }
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
		<title>Registrar Usuario</title>
		
	</head>

	<body>
	<div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="/api">Inicio</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
          
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                  <a class="nav-link" href="/api">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#">Link</a>
                </li>
              </ul>
              <form class="form-inline my-2 my-lg-0">
                
                    <a class="nav-link" href="/api/login">Iniciar Sesión<span class="sr-only">(current)</span></a>

                    <a class="nav-link" href="/api/register">Registrarse</a>
                  
              </form>
            </div>
          </nav>
    </div>
		<section class="login first grey">
			<div class="container">
				<div class="box-wrapper">				
					<div class="box box-border">
						<div class="box-body">
							<br>
							<center> <h2>Registro</h2></center><br>
							<form method="post" action="/api/register" enctype="multipart/form-data">
                                <div class="form-group">
									<label>Ingresa tú nombre de usuario</label>
									<input type="text" name="name" class="form-control" required />
								</div>
								<div class="form-group">
									<label>Ingresa tú correo:</label>
									<input type="email" name="email" class="form-control" required />
								</div>
								<div class="form-group">
									<label>Ingresa tú contraseña</label>
									<input type="password" name="password" class="form-control" required />
                                </div>
								                                
								<div class="form-group text-right">
									<button type="submit" class="btn btn-primary btn-block" id="submit" name="submit">Registrarse</button>
								</div>
								<div class="form-group text-center">
									<span class="text-muted">Ya tienes una cuenta! </span> <a href="/api/login">Inicia Sesión Aquí</a>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</section>

	</body>
	<script
			  src="https://code.jquery.com/jquery-3.5.1.min.js"
			  integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
			  crossorigin="anonymous">
		</script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</html>