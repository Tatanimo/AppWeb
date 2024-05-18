<?php
namespace App\Utils;

class ArrayUtils
{
    /**
     * Check if any element in the array satisfies the given callback condition.
     *
     * @param array $array The array to check.
     * @param callable $callback The callback function to apply to each element.
     * @return bool True if any element satisfies the condition, false otherwise.
     */
    public static function arraySome(array $array, callable $callback): bool
    {
        return count(array_filter($array, $callback)) > 0;
    }

}