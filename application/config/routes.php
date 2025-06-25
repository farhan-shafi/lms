<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'home';
$route['404_override'] = 'errors/page_missing';
$route['translate_uri_dashes'] = FALSE;

// Test route
$route['test'] = 'test/index';

// Course routes - moved to top for priority
$route['courses'] = 'courses/index';
$route['course/(:any)'] = 'course/view/$1';
$route['course/category/(:any)'] = 'course/category/$1';
$route['course/search'] = 'course/search';
$route['course/enroll/(:num)'] = 'course/enroll/$1';
$route['course/learn/(:num)'] = 'course/learn/$1';
$route['course/learn/(:num)/(:num)'] = 'course/learn/$1/$2';
$route['course/complete/(:num)'] = 'course/complete/$1';
$route['course/rate/(:num)'] = 'course/rate/$1';
$route['course/certificate/(:num)'] = 'course/certificate/$1';

// Authentication routes
$route['login'] = 'auth/login';
$route['register'] = 'auth/register';
$route['logout'] = 'auth/logout';

// Dashboard routes
$route['dashboard'] = 'dashboard/index';
$route['dashboard/student'] = 'dashboard/student';
$route['dashboard/instructor'] = 'dashboard/instructor';
$route['dashboard/admin'] = 'dashboard/admin';
$route['dashboard/profile'] = 'dashboard/profile';
$route['dashboard/change_password'] = 'dashboard/change_password';
$route['dashboard/courses'] = 'dashboard/courses';
$route['dashboard/certificates'] = 'dashboard/certificates';
$route['dashboard/certificate/(:num)'] = 'dashboard/certificate/$1';
$route['dashboard/notifications'] = 'dashboard/notifications';
$route['dashboard/mark_notification_read'] = 'dashboard/mark_notification_read';
$route['dashboard/mark_all_notifications_read'] = 'dashboard/mark_all_notifications_read';
$route['dashboard/update_notification_preferences'] = 'dashboard/update_notification_preferences';
$route['dashboard/security'] = 'dashboard/security';
$route['dashboard/delete_account'] = 'dashboard/delete_account';

// Instructor routes
$route['instructor'] = 'instructor/dashboard';
$route['instructor/dashboard'] = 'instructor/dashboard';
$route['instructor/courses'] = 'instructor/courses';
$route['instructor/create_course'] = 'instructor/create_course';
$route['instructor/edit_course/(:num)'] = 'instructor/edit_course/$1';
$route['instructor/toggle_course_status/(:num)'] = 'instructor/toggle_course_status/$1';
$route['instructor/add_module/(:num)'] = 'instructor/add_module/$1';
$route['instructor/edit_module/(:num)'] = 'instructor/edit_module/$1';
$route['instructor/delete_module/(:num)'] = 'instructor/delete_module/$1';
$route['instructor/manage_lessons/(:num)'] = 'instructor/manage_lessons/$1';
$route['instructor/add_lesson/(:num)'] = 'instructor/add_lesson/$1';
$route['instructor/edit_lesson/(:num)'] = 'instructor/edit_lesson/$1';
$route['instructor/delete_lesson/(:num)'] = 'instructor/delete_lesson/$1';
$route['instructor/add_quiz/(:num)'] = 'instructor/add_quiz/$1';
$route['instructor/manage_questions/(:num)'] = 'instructor/manage_questions/$1';
$route['instructor/add_question/(:num)'] = 'instructor/add_question/$1';
$route['instructor/edit_question/(:num)'] = 'instructor/edit_question/$1';
$route['instructor/delete_question/(:num)'] = 'instructor/delete_question/$1';
$route['instructor/course_analytics/(:num)'] = 'instructor/course_analytics/$1';
$route['instructor/earnings'] = 'instructor/earnings';
$route['instructor/request_payout'] = 'instructor/request_payout';

// Module routes
$route['module/index/(:num)'] = 'module/index/$1';
$route['module/create/(:num)'] = 'module/create/$1';
$route['module/view/(:num)'] = 'module/view/$1';
$route['module/edit/(:num)'] = 'module/edit/$1';
$route['module/delete/(:num)'] = 'module/delete/$1';

// Lesson routes
$route['lesson/create/(:num)'] = 'lesson/create/$1';
$route['lesson/view/(:num)'] = 'lesson/view/$1';
$route['lesson/edit/(:num)'] = 'lesson/edit/$1';
$route['lesson/delete/(:num)'] = 'lesson/delete/$1';
$route['lesson/complete/(:num)'] = 'lesson/complete/$1';

// Quiz routes
$route['quiz/create/(:num)'] = 'quiz/create/$1';
$route['quiz/view/(:num)'] = 'quiz/view/$1';
$route['quiz/take/(:num)'] = 'quiz/take/$1';
$route['quiz/submit/(:num)'] = 'quiz/submit/$1';
$route['quiz/result/(:num)'] = 'quiz/result/$1';
$route['quiz/edit/(:num)'] = 'quiz/edit/$1';
$route['quiz/delete/(:num)'] = 'quiz/delete/$1';
$route['quiz/answer'] = 'quiz/answer';
$route['quiz/history/(:num)'] = 'quiz/history/$1';
$route['quiz/review/(:num)'] = 'quiz/review/$1';

// Payment routes
$route['payment/checkout/(:num)'] = 'payment/checkout/$1';
$route['payment/process'] = 'payment/process';
$route['payment/success'] = 'payment/success';
$route['payment/cancel'] = 'payment/cancel';

// Admin routes
$route['admin'] = 'admin/index';
$route['admin/dashboard'] = 'admin/index';
$route['admin/users'] = 'admin/users';
$route['admin/edit_user/(:num)'] = 'admin/edit_user/$1';
$route['admin/delete_user/(:num)'] = 'admin/delete_user/$1';
$route['admin/courses'] = 'admin/courses';
$route['admin/update_course_status/(:num)'] = 'admin/update_course_status/$1';
$route['admin/categories'] = 'admin/categories';
$route['admin/edit_category'] = 'admin/edit_category';
$route['admin/edit_category/(:num)'] = 'admin/edit_category/$1';
$route['admin/delete_category/(:num)'] = 'admin/delete_category/$1';
$route['admin/settings'] = 'admin/settings';
$route['admin/payments'] = 'admin/payments';
$route['admin/instructors'] = 'admin/instructors';
$route['admin/students'] = 'admin/students';
$route['admin/enrollments'] = 'admin/enrollments';

// Home routes
$route['about'] = 'home/about';
$route['contact'] = 'home/contact';
$route['terms'] = 'home/terms';
$route['privacy'] = 'home/privacy';
$route['subscribe'] = 'home/subscribe';
