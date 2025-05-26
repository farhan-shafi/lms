<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Time Elapsed Helper
 *
 * This helper provides functions to display time in a "time ago" format.
 */

if (!function_exists('time_elapsed_string')) {
    /**
     * Returns a string representing time elapsed since the given timestamp
     *
     * @param string $datetime The date and time to format
     * @param bool $full Whether to show the full format or a shorter version
     * @return string The formatted time string
     */
    function time_elapsed_string($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }
}

/**
 * Returns a human-readable file size
 *
 * @param int $bytes The size in bytes
 * @param int $decimals The number of decimal places to include
 * @return string The formatted file size
 */
if (!function_exists('format_file_size')) {
    function format_file_size($bytes, $decimals = 2) {
        $size = array('B','KB','MB','GB','TB','PB','EB','ZB','YB');
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . ' ' . @$size[$factor];
    }
}

/**
 * Truncates text to a specified length and adds ellipsis if needed
 *
 * @param string $text The text to truncate
 * @param int $length The maximum length
 * @param string $suffix The suffix to add to truncated text
 * @return string The truncated text
 */
if (!function_exists('truncate_text')) {
    function truncate_text($text, $length = 100, $suffix = '...') {
        if (strlen($text) <= $length) {
            return $text;
        }
        
        return substr($text, 0, $length) . $suffix;
    }
}

/**
 * Converts a number to a rating display with stars
 *
 * @param float $rating The rating value (0-5)
 * @return string HTML with star icons representing the rating
 */
if (!function_exists('display_rating')) {
    function display_rating($rating) {
        $output = '';
        $rating = floatval($rating);
        
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $rating) {
                $output .= '<i class="fas fa-star"></i>';
            } elseif ($i - 0.5 <= $rating) {
                $output .= '<i class="fas fa-star-half-alt"></i>';
            } else {
                $output .= '<i class="far fa-star"></i>';
            }
        }
        
        return $output;
    }
}

/**
 * Calculates the progress percentage of a course
 *
 * @param array $course_items The total items in a course
 * @param array $completed_items The completed items
 * @return int The progress percentage
 */
if (!function_exists('calculate_progress')) {
    function calculate_progress($course_items, $completed_items) {
        if (empty($course_items)) {
            return 0;
        }
        
        return round(($completed_items / $course_items) * 100);
    }
}

/**
 * Formats a date in a user-friendly way
 *
 * @param string $date The date to format
 * @param string $format The format to use
 * @return string The formatted date
 */
if (!function_exists('format_date')) {
    function format_date($date, $format = 'M d, Y') {
        return date($format, strtotime($date));
    }
}

/**
 * Checks if a user has permission to access a resource
 *
 * @param array $user The user array
 * @param string $permission The permission to check
 * @return bool Whether the user has the permission
 */
if (!function_exists('has_permission')) {
    function has_permission($user, $permission) {
        $CI =& get_instance();
        
        // Admin has all permissions
        if ($user['role'] == 'admin') {
            return true;
        }
        
        // Check role-based permissions
        $permissions = array(
            'student' => ['view_course', 'take_quiz', 'view_certificate'],
            'instructor' => ['view_course', 'create_course', 'edit_course', 'create_module', 'edit_module', 'create_lesson', 'edit_lesson', 'create_quiz', 'edit_quiz', 'view_students', 'view_earnings'],
            'admin' => ['*']
        );
        
        if (isset($permissions[$user['role']])) {
            return in_array($permission, $permissions[$user['role']]) || in_array('*', $permissions[$user['role']]);
        }
        
        return false;
    }
}
