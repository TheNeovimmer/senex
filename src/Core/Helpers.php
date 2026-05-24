<?php
namespace Core;

class Helpers {
    public static function slugify(string $text): string {
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, '-');
        $text = preg_replace('~-+~', '-', $text);
        $text = strtolower($text);
        return empty($text) ? 'n-a' : $text;
    }

    public static function truncate(string $text, int $length = 100): string {
        if (mb_strlen($text) <= $length) return $text;
        return mb_substr($text, 0, $length) . '...';
    }

    public static function timeAgo(string $datetime): string {
        $timestamp = strtotime($datetime);
        $diff = time() - $timestamp;
        if ($diff < 60) return 'à l\'instant';
        if ($diff < 3600) return floor($diff / 60) . ' min';
        if ($diff < 86400) return floor($diff / 3600) . 'h';
        if ($diff < 2592000) return floor($diff / 86400) . 'j';
        return date('d/m/Y', $timestamp);
    }

    public static function formatDuration(int $seconds): string {
        $h = floor($seconds / 3600);
        $m = floor(($seconds % 3600) / 60);
        $s = $seconds % 60;
        if ($h > 0) return sprintf('%dh %02dm', $h, $m);
        if ($m > 0) return sprintf('%dm %02ds', $m, $s);
        return sprintf('%ds', $s);
    }

    public static function formatNumber(int $number): string {
        if ($number >= 1000000) return round($number / 1000000, 1) . 'M';
        if ($number >= 1000) return round($number / 1000, 1) . 'k';
        return (string)$number;
    }

    public static function difficultyBadge(string $difficulty): string {
        $colors = [
            'easy' => '#4CAF50',
            'medium' => '#FF9800',
            'hard' => '#F44336',
            'extreme' => '#9C27B0'
        ];
        $color = $colors[$difficulty] ?? '#666';
        return "<span class=\"badge\" style=\"background: $color; color: #fff;\">$difficulty</span>";
    }

    public static function statusBadge(string $status): string {
        $colors = [
            'draft' => '#666',
            'pending' => '#FF9800',
            'active' => '#4CAF50',
            'live' => '#F44336',
            'completed' => '#2196F3',
            'ended' => '#666',
            'cancelled' => '#999'
        ];
        $color = $colors[$status] ?? '#666';
        return "<span class=\"badge\" style=\"background: $color; color: #fff;\">$status</span>";
    }
}
