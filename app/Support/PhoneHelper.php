<?php

namespace App\Support;

class PhoneHelper
{
    /**
     * Normalize a phone number to Turkish format (+90XXXXXXXXXX) or generic international format.
     *
     * @param string|null $phone
     * @return string|null
     */
    public static function normalize(?string $phone): ?string
    {
        if (empty($phone)) {
            return null;
        }

        // 1. Initial Clean: Remove all non-numeric characters (spaces, dashes, etc.)
        $cleanPhone = preg_replace('/[^0-9]/', '', $phone);

        if (empty($cleanPhone)) {
            return null;
        }

        // 2. Strip leading zeros or '+' for a "clean" numeric base
        $baseNumber = ltrim($cleanPhone, '0+');

        // Case A: Standard Turkish Mobile (e.g., 5321234567 -> 10 digits)
        if (strlen($baseNumber) === 10) {
            return '+90' . $baseNumber;
        }

        // Case B: Already has Turkish Country Code (e.g., 905321234567 -> 12 digits)
        if (strlen($baseNumber) === 12 && str_starts_with($baseNumber, '90')) {
            return '+' . $baseNumber;
        }

        // Case C: International number or other format
        return '+' . $baseNumber;
    }

    /**
     * Extract a phone number from a string, specifically looking for "Cep:" label.
     *
     * @param string|null $text
     * @return string|null
     */
    public static function extract(?string $text): ?string
    {
        if (empty($text)) {
            return null;
        }

        if (preg_match('/Cep:(\d+)/', $text, $matches)) {
            // $matches[1] might still contain "5323520305 İş:3124252589" because of the greedy match
            // We use a secondary match to grab ONLY the first continuous block of digits
            preg_match('/^\d+/', $matches[1], $preciseMatch);
            $text = $preciseMatch[0] ?? null;
        }

        return $text;
    }

    /**
     * Combined extract and normalize.
     *
     * @param string|null $text
     * @return string|null
     */
    public static function format(?string $text): ?string
    {
        $extracted = self::extract($text);

        return self::normalize($extracted);
    }
}
