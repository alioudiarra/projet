<?php

$db = mysqli_connect("localhost", "root", "root", "projet");
// connexion a la BD
?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<style>
    a:hover{
        text-decoration: underline;
    }
</style>

<nav class="navbar navbar-expand-lg bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">fomLoic</a>

<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
  <span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse" id="navbarSupportedContent">
  <ul class="navbar-nav me-auto mb-2 mb-lg-0">
    <li class="nav-item">
      <a class="nav-link" href="users.php">Users</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="chat.php">Chat</a>
    </li>
  </ul>
  <form class="d-flex" role="search">
    <a class="btn btn-danger" href="register.php">
      Register <i class="fa-solid fa-person"></i>
    </a>
  </form>
</div>
  </div>
</nav>
<body>
<br>
<form class="bg-light m-auto p-5 rounded-3 shadow-lg w-50" action="" method="post">
<h1>Login</h1>

<div class="mb-3">
    <label class="form-label">Pseudo</label>
    <input type="text" class="form-control" name="pseudo">
</div>
<div class="mb-3">
    <label class="form-label">Password</label>
    <input type="password" class="form-control" name="password">
</div>
<button type="submit" class="btn btn-danger">Submit</button>
</form>
<br>
<hr>
</body>
</html>
