<?php



$punchIn = $todayAttendance['punch_in'] ?? null;

$punchOut = $todayAttendance['punch_out'] ?? null;

$totalHours = $todayAttendance['total_hours'] ?? '0 hrs';

$status = $todayAttendance['status'] ?? 'Absent';

?>

<!DOCTYPE html>
<html>

<head>

    <title>Employee Dashboard</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-gray-100 min-h-screen">

<!-- Navbar -->

<nav class="bg-indigo-600 shadow-lg">

    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">

        <h1 class="text-2xl font-bold text-white">
            Employee Dashboard
        </h1>

        <a
            href="index.php?page=logout"
            class="bg-red-500 hover:bg-red-600 text-white px-5 py-2 rounded-xl transition"
        >
            Logout
        </a>

    </div>

</nav>

<!-- Main Container -->

<div class="max-w-7xl mx-auto p-8">

    <!-- Welcome Card -->

    <div class="bg-white rounded-3xl shadow-xl p-8 mb-8">

        <div class="flex flex-col md:flex-row justify-between items-center gap-6">

            <!-- Employee Info -->

            <div>

                <h2 class="text-4xl font-bold text-gray-800 mb-2">

                    Welcome,
                    <?= htmlspecialchars($employee['full_name']) ?>

                </h2>

                <p class="text-gray-500 text-lg mb-1">

                    Employee ID :
                    <?= $employee['id'] ?>

                </p>

                <p class="text-gray-500 text-lg mb-1">

                    Email :
                    <?= $employee['email'] ?>

                </p>

                <p class="text-gray-500 text-lg">

                    Mobile :
                    <?= $employee['mobile'] ?>

                </p>

            </div>

            <!-- Profile Image -->

            <div>

                <?php if(!empty($employee['profile_image'])): ?>

                    <img
                        src="uploads/<?= $employee['profile_image'] ?>"
                        class="w-32 h-32 rounded-full object-cover border-4 border-indigo-500 shadow-lg"
                    >

                <?php else: ?>

                    <div class="w-32 h-32 rounded-full bg-indigo-200 flex items-center justify-center text-4xl font-bold text-indigo-700">

                        <?= strtoupper(substr($employee['full_name'],0,1)) ?>

                    </div>

                <?php endif; ?>

            </div>

        </div>

    </div>

    <!-- Attendance Cards -->

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

        <!-- Punch In -->

        <div class="bg-white rounded-3xl shadow-lg p-6">

            <h3 class="text-gray-500 text-lg">
                Punch In
            </h3>

            <p class="text-3xl font-bold text-green-500 mt-3">

                <?= $punchIn
                    ? date('h:i A', strtotime($punchIn))
                    : 'Not Punched In'
                ?>

            </p>

        </div>

        <!-- Punch Out -->

        <div class="bg-white rounded-3xl shadow-lg p-6">

            <h3 class="text-gray-500 text-lg">
                Punch Out
            </h3>

            <p class="text-3xl font-bold text-red-500 mt-3">

                <?= $punchOut
                    ? date('h:i A', strtotime($punchOut))
                    : 'Not Punched Out'
                ?>

            </p>

        </div>

        <!-- Total Hours -->

        <div class="bg-white rounded-3xl shadow-lg p-6">

            <h3 class="text-gray-500 text-lg">
                Working Hours
            </h3>

            <p class="text-3xl font-bold text-indigo-600 mt-3">

                <?= $totalHours ?>

            </p>

        </div>

        <!-- Status -->

        <div class="bg-white rounded-3xl shadow-lg p-6">

            <h3 class="text-gray-500 text-lg">
                Status
            </h3>

            <p class="text-3xl font-bold text-yellow-500 mt-3">

                <?= $status ?>

            </p>

        </div>

    </div>

    <!-- Attendance Actions -->

    <div class="bg-white rounded-3xl shadow-xl p-8 mb-8">

        <h2 class="text-2xl font-bold text-gray-700 mb-6">
            Attendance Actions
        </h2>

        <div class="flex flex-wrap gap-5">

            <!-- Punch In -->

            <a
                href="index.php?page=punchin"
                class="bg-green-500 hover:bg-green-600 text-white px-8 py-4 rounded-2xl text-lg font-semibold transition shadow-lg"
            >
                Punch In
            </a>

            <!-- Punch Out -->

            <a
                href="index.php?page=punchout"
                class="bg-red-500 hover:bg-red-600 text-white px-8 py-4 rounded-2xl text-lg font-semibold transition shadow-lg"
            >
                Punch Out
            </a>

        </div>

    </div>

    <!-- Monthly Summary -->

    <div class="bg-white rounded-3xl shadow-xl p-8 mb-8">

        <h2 class="text-2xl font-bold text-gray-700 mb-6">
            Monthly Attendance Summary
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <div class="bg-indigo-50 p-6 rounded-2xl">

                <h3 class="text-gray-600">
                    Total Present
                </h3>

                <p class="text-4xl font-bold text-indigo-600 mt-2">

                    <?= $monthlySummary['total_present'] ?? 0 ?>

                </p>

            </div>

        </div>

    </div>

    <!-- Attendance History -->

    <div class="bg-white rounded-3xl shadow-xl overflow-hidden">

        <div class="p-6 border-b">

            <h2 class="text-2xl font-bold text-gray-700">
                Attendance History
            </h2>

        </div>

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-indigo-600 text-white">

                    <tr>

                        <th class="p-4 text-left">
                            Date
                        </th>

                        <th class="p-4 text-left">
                            Punch In
                        </th>

                        <th class="p-4 text-left">
                            Punch Out
                        </th>

                        <th class="p-4 text-left">
                            Working Hours
                        </th>

                        <th class="p-4 text-left">
                            Status
                        </th>

                    </tr>

                </thead>

                <tbody>

                    <?php if(!empty($attendanceHistory)): ?>

                        <?php foreach($attendanceHistory as $row): ?>

                            <tr class="border-b hover:bg-gray-50">

                                <td class="p-4">
                                    <?= $row['attendance_date'] ?>
                                </td>

                                <td class="p-4">

                                    <?= $row['punch_in']
                                        ? date('h:i A', strtotime($row['punch_in']))
                                        : '-'
                                    ?>

                                </td>

                                <td class="p-4">

                                    <?= $row['punch_out']
                                        ? date('h:i A', strtotime($row['punch_out']))
                                        : '-'
                                    ?>

                                </td>

                                <td class="p-4">
                                    <?= $row['total_hours'] ?>
                                </td>

                                <td class="p-4">

                                    <span class="bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm font-semibold">

                                        <?= $row['status'] ?>

                                    </span>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <tr>

                            <td colspan="5" class="p-6 text-center text-gray-500">

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