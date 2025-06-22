<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Time Elapsed String Helper
 *
 * Formats a timestamp into a relative time string (e.g., "5 minutes ago", "2 days ago")
 *
 * @param string $datetime The date/time string to be converted
 * @param bool $full Whether to show the full date/time
 * @return string The elapsed time string
 */
if (!function_exists('time_elapsed_string')) {
    function time_elapsed_string($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        // Calculate weeks
        $weeks = floor($diff->days / 7);
        $days = $diff->days - ($weeks * 7);

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
            if ($k === 'w' && $weeks) {
                $v = $weeks . ' ' . $v . ($weeks > 1 ? 's' : '');
            } else if ($k === 'd' && $days) {
                $v = $days . ' ' . $v . ($days > 1 ? 's' : '');
            } else if ($k === 'y' && $diff->y) {
                $v = $diff->y . ' ' . $v . ($diff->y > 1 ? 's' : '');
            } else if ($k === 'm' && $diff->m) {
                $v = $diff->m . ' ' . $v . ($diff->m > 1 ? 's' : '');
            } else if ($k === 'h' && $diff->h) {
                $v = $diff->h . ' ' . $v . ($diff->h > 1 ? 's' : '');
            } else if ($k === 'i' && $diff->i) {
                $v = $diff->i . ' ' . $v . ($diff->i > 1 ? 's' : '');
            } else if ($k === 's' && $diff->s) {
                $v = $diff->s . ' ' . $v . ($diff->s > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }
}
