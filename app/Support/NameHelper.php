<?php

namespace App\Support;

class NameHelper
{
    /**
     * Concatenate first and last name to get full name.
     *
     * @param string|null $firstName
     * @param string|null $lastName
     * @return string|null
     */
    public static function fullName(?string $firstName, ?string $lastName): ?string
    {
        if (empty($firstName) && empty($lastName)) {
            return null;
        }

        return trim(($firstName ?? '') . ' ' . ($lastName ?? ''));
    }
}
