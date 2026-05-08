<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <form class="card p-4 mx-auto w-50" method="POST" >
        
        <h3 class="text-center mb-3">Admin Login</h3>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <a href="/EMPLOYEE_M_SYSTEM/public/?page=dashboard"><button class="btn btn-primary w-100 mb-2" type="submit">
            Login
        </button></a>

        <a href="/EMPLOYEE_M_SYSTEM/public/?page=register" class="btn btn-primary w-100">
        Register
    </a>

    </form>

</div>

</body>
</html>