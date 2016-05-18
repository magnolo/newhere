<?php
namespace App\Services;

class Translation
{
    public function hasChanged(array $current, array $new)
    {
        return (bool)array_diff($new, $current);
    }
}