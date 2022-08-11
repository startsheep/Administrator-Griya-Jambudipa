<?php

use Illuminate\Support\Str;
use Modules\Auth\Models\User;

if (!function_exists('base64url_encode')) {
    /**
     * @param mixed $data
     * @return string
     */
    function base64url_encode($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
}

if (!function_exists('base64url_decode')) {
    /**
     * @param mixed $data
     * @return string
     */
    function base64url_decode($data)
    {
        return base64_decode(strtr($data, '-_', '+/') . str_repeat('=', 3 - (3 + strlen($data)) % 4));
    }
}

if (!function_exists('round_up')) {
    /**
     * @param float $value
     * @param int $precision
     * @return float
     */
    function round_up($value, $precision = 2)
    {
        return round($value, $precision);
    }
}

if (!function_exists('random_str')) {
    function random_str(int $length, string $keyspace = ''): string
    {
        $keyspace = $keyspace ?: '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $pieces = [];
        $max = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $pieces[] = $keyspace[random_int(0, $max)];
        }
        return implode('', $pieces);
    }
}

if (!function_exists('create_array_for_phone')) {
    function create_array_for_phone(?string $phoneNumber): ?array
    {
        $value = normalize_string($phoneNumber ?? '_');

        if (!is_numeric($value)) {
            return null;
        }

        $phones = [];
        if (substr($value, 0, 2) == '08') {
            $phones['international'] = '0' . substr($value, 1, strlen($value));
            $phones['country_id'] = '62' . substr($value, 1, strlen($value));
            $phones['phone'] = substr($value, 1, strlen($value));
            return $phones;
        }

        if (substr($value, 0, 2) == '62') {
            $phones['international'] = '0' . substr($value, 2, strlen($value));
            $phones['country_id'] = '62' . substr($value, 2, strlen($value));
            $phones['phone'] = substr($value, 2, strlen($value));
            return $phones;
        }

        if (substr($value, 0, 3) == '+62') {
            $phones['international'] = '0' . substr($value, 3, strlen($value));
            $phones['country_id'] = '62' . substr($value, 3, strlen($value));
            $phones['phone'] = substr($value, 3, strlen($value));
            return $phones;
        }

        return [
            'international' => "0" . $value,
            'country_id' => "62" . $value,
            'phone' => $value,
        ];
    }
}

if (!function_exists('mask_email')) {
    function mask_email(string $email): string
    {
        $chunks = explode('@', $email);
        $strLength1 = strlen($chunks['0']);
        $firstChar1 = substr($chunks['0'], 0, (int)floor($strLength1 * 0.3));
        $stars1 = str_repeat('*', $strLength1 - 1);

        if (count($chunks) == 1) {
            return $firstChar1 . $stars1 . substr($chunks['0'], -2);
        }

        $strLength2 = strlen($chunks['1']);
        $firstChar2 = substr($chunks['1'], 0, -1 * ($strLength2 - 3));
        $stars2 = str_repeat('*', $strLength2 - 3);

        $email = $firstChar1 . $stars1 . '@' . $firstChar2 . $stars2;
        return $email;
    }
}

if (!function_exists('normalize_words')) {
    /**
     * @param  string  $value
     * @return integer
     */
    function normalize_words($value)
    {
        $value = str_replace('> ', '>', $value);
        $value = str_replace('/> ', '/>', $value);
        $value = str_replace(' <', '<', $value);
        $value = str_replace(' </', '</', $value);

        $decoded_text = strip_tags($value);

        return preg_replace("/\r\n|\r|\n/", ' ', preg_replace('/(\&nbsp\;|\s)+/', ' ', $decoded_text));
    }
}

if (!function_exists('word_counter')) {
    /**
     * @param  string  $value
     * @return integer
     */
    function word_counter($value)
    {
        $words = explode(' ', normalize_words($value));

        return count($words);
    }
}

if (!function_exists('normalize_string')) {
    /**
     * @param  string  $value
     * @return string|null
     */
    function normalize_string($value)
    {
        $value = str_replace('-', '', $value);

        return preg_replace('/[^A-Za-z0-9\-]/', '', $value);
    }
}

if (!function_exists('title')) {
    /**
     * @param  string  $value
     * @return string|null
     */
    function title($value)
    {
        return Str::remove(' ', ucwords(Str::of($value)->replace('_', ' ')));
    }
}

if (!function_exists('includeRouteFiles')) {

    /**
     * @param string $folder
     * @return void
     */
    function includeRouteFiles(string $folder)
    {
        // iterate thru the v1 folder recursively
        $dirIterator = new RecursiveDirectoryIterator($folder);

        /** @var RecursiveDirectoryIterator | \RecursiveIteratorIterator $it */
        $it = new RecursiveIteratorIterator($dirIterator);

        // require the file in each iteration
        while ($it->valid()) {
            if (
                !$it->isDot()
                && $it->isFile()
                && $it->isReadable()
                && $it->current()->getExtension() === 'php'
            ) {
                require $it->key();
                //                require $it->current()->getPathname();
            }
            $it->next();
        }
    }
}
