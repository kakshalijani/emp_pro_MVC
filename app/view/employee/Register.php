<!DOCTYPE html>
<html>
<head>
    <title>Employee Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-5 pb-3 ">

<form method="POST" enctype="multipart/form-data" class="w-50 mx-auto  ">

    <h3 class="text-center mb-4">Registration</h3>

    <div class="mb-2">
        <label>FullName</label>
        <input type="text" name="name" class="form-control" required>
    </div>

    <div class="mb-2">
        <label>Email</label>
        <input type="email" name="email" class="form-control" required>
    </div>

    <div class="mb-2">
        <label>Password</label>
        <input type="password" name="password" class="form-control" required>
    </div>

    <div class="mb-2">
        <label>Mobile</label>
        <input type="text" name="mobile" class="form-control" required>
    </div>

    <div class="mb-2">
        <label>Profile Image</label>
        <input type="file" name="profile_image" class="form-control">
    </div>

    <div class="mb-2">
        <label>Role</label>
        <select name="role" class="form-control">
            <option value="admin">Admin</option>
            <option value="employee">Employee</option>
        </select>
    </div>

    <div class="mb-3">
        <label>Status</label>
        <select name="status" class="form-control">
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
        </select>
    </div>

    <button class="btn btn-success w-100 mb-2" type="submit">
        Register
    </button>

    <a href="/EMPLOYEE_M_SYSTEM/public/?page=login" class="btn btn-primary w-100">
        Login
    </a>

</form>

</div>

</body>
</html>