<!DOCTYPE html>
<html>

<head>

    <title>Admin Dashboard</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-gray-100 min-h-screen">

<!-- Navbar -->

<nav class="bg-indigo-700 shadow-xl">

    <div class="max-w-7xl mx-auto px-6 py-5 flex justify-between items-center">

        <div>

            <h1 class="text-3xl font-bold text-white">
                Admin Dashboard
            </h1>

            <p class="text-indigo-200 text-sm mt-1">
                Employee Attendance Management System
            </p>

        </div>

        <div class="flex gap-4">

            <a
                href="index.php?page=attendance"
                class="bg-white text-indigo-700 px-5 py-3 rounded-xl font-semibold hover:bg-gray-200 transition"
            >
                Attendance Panel
            </a>

            <a
                href="index.php?page=logout"
                class="bg-red-500 text-white px-5 py-3 rounded-xl font-semibold hover:bg-red-600 transition"
            >
                Logout
            </a>

        </div>

    </div>

</nav>

<!-- Main Container -->

<div class="max-w-7xl mx-auto p-8">

    <!-- Top Cards -->

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">

        <!-- Total Employees -->

        <div class="bg-white rounded-3xl shadow-xl p-8">

            <h2 class="text-gray-500 text-lg">
                Total Employees
            </h2>

            <p class="text-5xl font-bold text-indigo-600 mt-4">

                <?= $totalEmployees ?>

            </p>

        </div>

        <!-- Total Attendance -->

        <div class="bg-white rounded-3xl shadow-xl p-8">

            <h2 class="text-gray-500 text-lg">
                Attendance Records
            </h2>

            <p class="text-5xl font-bold text-green-500 mt-4">

                <?= $totalAttendance ?>

            </p>

        </div>

        <!-- Present Today -->

        <div class="bg-white rounded-3xl shadow-xl p-8">

            <h2 class="text-gray-500 text-lg">
                Present Today
            </h2>

            <p class="text-5xl font-bold text-yellow-500 mt-4">

                <?= $totalPresentToday ?>

            </p>

        </div>

    </div>

    <!-- Search Attendance -->

    <div class="bg-white rounded-3xl shadow-xl p-8 mb-10">

        <div class="flex justify-between items-center mb-6">

            <h2 class="text-2xl font-bold text-gray-700">
                Search Attendance
            </h2>

        </div>

        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-5">

            <input
                type="hidden"
                name="page"
                value="dashboard"
            >

            <!-- Search Date -->

            <input
                type="date"
                name="date"
                class="border border-gray-300 p-4 rounded-2xl focus:outline-none focus:ring-2 focus:ring-indigo-500"
            >

            <!-- Search Employee -->

            <input
                type="text"
                name="employee"
                placeholder="Search Employee Name"
                class="border border-gray-300 p-4 rounded-2xl focus:outline-none focus:ring-2 focus:ring-indigo-500"
            >

            <!-- Search Button -->

            <button
                type="submit"
                class="bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-semibold transition"
            >
                Search
            </button>

            <!-- Reset -->

            <a
                href="index.php?page=dashboard"
                class="bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-2xl font-semibold flex items-center justify-center transition"
            >
                Reset
            </a>

        </form>

    </div>

    <!-- Employee Table -->

    <div class="bg-white rounded-3xl shadow-xl overflow-hidden mb-10">

        <div class="p-6 border-b border-gray-200">

            <h2 class="text-2xl font-bold text-gray-700">
                All Employees
            </h2>

        </div>

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-indigo-600 text-white">

                    <tr>

                        <th class="p-5 text-left">ID</th>
                        <th class="p-5 text-left">Name</th>
                        <th class="p-5 text-left">Email</th>
                        <th class="p-5 text-left">Mobile</th>
                        <th class="p-5 text-left">Role</th>
                        <th class="p-5 text-left">Status</th>

                    </tr>

                </thead>

                <tbody>

                    <?php foreach ($employees as $emp): ?>

                        <tr class="border-b hover:bg-gray-50 transition">

                            <td class="p-5">
                                <?= $emp['id']; ?>
                            </td>

                            <td class="p-5 font-semibold text-gray-700">
                                <?= $emp['full_name']; ?>
                            </td>

                            <td class="p-5">
                                <?= $emp['email']; ?>
                            </td>

                            <td class="p-5">
                                <?= $emp['mobile']; ?>
                            </td>

                            <td class="p-5">

                                <?php if($emp['role'] == 'admin'): ?>

                                    <span class="bg-indigo-100 text-indigo-700 px-4 py-2 rounded-full text-sm font-semibold">

                                        Admin

                                    </span>

                                <?php else: ?>

                                    <span class="bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm font-semibold">

                                        Employee

                                    </span>

                                <?php endif; ?>

                            </td>

                            <td class="p-5">

                                <?php if($emp['status'] == 'active'): ?>

                                    <span class="bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm font-semibold">

                                        Active

                                    </span>

                                <?php else: ?>

                                    <span class="bg-red-100 text-red-700 px-4 py-2 rounded-full text-sm font-semibold">

                                        Inactive

                                    </span>

                                <?php endif; ?>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                </tbody>

            </table>

        </div>

    </div>

    <!-- Attendance Table -->

    <div class="bg-white rounded-3xl shadow-xl overflow-hidden">

        <div class="p-6 border-b border-gray-200">

            <h2 class="text-2xl font-bold text-gray-700">
                Attendance Records
            </h2>

        </div>

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-indigo-600 text-white">

                    <tr>

                        <th class="p-5 text-left">Employee</th>
                        <th class="p-5 text-left">Date</th>
                        <th class="p-5 text-left">Punch In</th>
                        <th class="p-5 text-left">Punch Out</th>
                        <th class="p-5 text-left">Working Hours</th>
                        <th class="p-5 text-left">Status</th>
                        <th class="p-5 text-left">Action</th>

                    </tr>

                </thead>

                <tbody>

                    <?php if(!empty($attendanceRecords)): ?>

                        <?php foreach($attendanceRecords as $row): ?>

                            <tr class="border-b hover:bg-gray-50 transition">

                                <td class="p-5 font-semibold text-gray-700">
                                    <?= $row['full_name'] ?>
                                </td>

                                <td class="p-5">
                                    <?= $row['attendance_date'] ?>
                                </td>

                                <td class="p-5">

                                    <?= date(
                                        'h:i A',
                                        strtotime($row['punch_in'])
                                    ) ?>

                                </td>

                                <td class="p-5">

                                    <?= $row['punch_out']
                                        ? date(
                                            'h:i A',
                                            strtotime($row['punch_out'])
                                        )
                                        : '-'
                                    ?>

                                </td>

                                <td class="p-5">
                                    <?= $row['total_hours'] ?>
                                </td>

                                <td class="p-5">

                                    <span class="bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm font-semibold">

                                        <?= $row['status'] ?>

                                    </span>

                                </td>

                                <td class="p-5 flex gap-3">

                                    <!-- Edit -->

                                    <a
                                        href="index.php?page=editattendance&id=<?= $row['id'] ?>"
                                        class="bg-yellow-400 hover:bg-yellow-500 text-white px-4 py-2 rounded-xl text-sm font-semibold transition"
                                    >
                                        Edit
                                    </a>

                                    <!-- Delete -->

                                    <a
                                        href="index.php?page=deleteattendance&id=<?= $row['id'] ?>"
                                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-xl text-sm font-semibold transition"
                                        onclick="return confirm('Delete Attendance Record?')"
                                    >
                                        Delete
                                    </a>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <tr>

                            <td colspan="7" class="p-8 text-center text-gray-500">

                                No Attendance Records Found

                            </td>

                        </tr>

                    <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

</body>
</html>