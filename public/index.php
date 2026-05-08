<?php


error_reporting(E_ALL);

ini_set('display_errors', 1);



session_start();



require_once __DIR__ . '/../app/controller/EmployeeController.php';

require_once __DIR__ . '/../app/controller/DashboardController.php';

require_once __DIR__ . '/../app/controller/EmployeeDeshController.php';

require_once __DIR__ . '/../app/controller/AttendanceController.php';

require_once __DIR__ . '/../app/controller/AdminAttendanceController.php';



$authController = new EmployeeController();

$dashboardController = new DashboardController();

$employeeDashboardController = new EmployeeDeshController();

$attendanceController = new AttendanceController();

$adminAttendanceController = new AdminAttendanceController();



$page = $_GET['page'] ?? 'login';


switch ($page)
{
   

    case 'register':

        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $authController->register();
        }
        else
        {
            $authController->registerView();
        }

    break;

    

    case 'login':

        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $authController->login();
        }
        else
        {
            $authController->loginView();
        }

    break;

    

    case 'dashboard':

        if (!isset($_SESSION['admin']))
        {
            header("Location: index.php?page=login");

            exit;
        }

        $dashboardController->dashboardView();

    break;

   

    case 'empdashboard':

        if (!isset($_SESSION['employee']))
        {
            header("Location: index.php?page=login");

            exit;
        }

        $employeeDashboardController->dashboardView();

    break;

   

    case 'punchin':

        if (!isset($_SESSION['employee']))
        {
            header("Location: index.php?page=login");

            exit;
        }

        $attendanceController->punchIn();

    break;

    

    case 'punchout':

        if (!isset($_SESSION['employee']))
        {
            header("Location: index.php?page=login");

            exit;
        }

        $attendanceController->punchOut();

    break;

    
    case 'attendance':

        if (!isset($_SESSION['admin']))
        {
            header("Location: index.php?page=login");

            exit;
        }

        $adminAttendanceController->index();

    break;

   

    case 'deleteattendance':

        if (!isset($_SESSION['admin']))
        {
            header("Location: index.php?page=login");

            exit;
        }

        $adminAttendanceController->delete();

    break;

    

    case 'logout':

        session_unset();

        session_destroy();

        header("Location: index.php?page=login");

        exit;

    break;

   
    default:

        http_response_code(404);

        echo '

        <!DOCTYPE html>

        <html>

        <head>

            <title>404</title>

            <script src="https://cdn.tailwindcss.com"></script>

        </head>

        <body class="bg-gray-100 min-h-screen flex items-center justify-center">

            <div class="bg-white p-10 rounded-3xl shadow-2xl text-center max-w-md">

                <h1 class="text-7xl font-bold text-red-500 mb-4">
                    404
                </h1>

                <p class="text-gray-600 text-lg mb-8">
                    Page Not Found
                </p>

                <a
                    href="index.php?page=login"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-2xl transition font-semibold"
                >
                    Back To Login
                </a>

            </div>

        </body>

        </html>

        ';
}