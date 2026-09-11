<?php

namespace App\Support;

class Security
{
    /**
     * Escape special characters in a string for SQL LIKE queries.
     * Escapes '%', '_', and the escape character itself.
     */
    public static function escapeLike(string $value, string $char = '\\'): string
    {
        return str_replace(
            [$char, '%', '_'],
            [$char.$char, $char.'%', $char.'_'],
            $value
        );
    }

    /**
     * Sanitize free-text input by stripping HTML/PHP tags,
     * removing null bytes, and trimming whitespace.
     */
    public static function cleanInput(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        // Remove null bytes
        $value = str_replace(chr(0), '', $value);

        // Remove <script> and <style> tags and their contents completely
        $value = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', '', $value);
        $value = preg_replace('/<style\b[^>]*>(.*?)<\/style>/is', '', $value);

        // Strip remaining HTML and PHP tags
        $value = strip_tags($value);

        return trim($value);
    }
}
