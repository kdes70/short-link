<?php

namespace App\Rules;

use App\Services\VirusTotal\VirusTotalUrl;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Validation\Rule;

/**
 * Class Virus
 */
class Virus implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     * @throws GuzzleException
     * @throws \Exception
     */
    public function passes($attribute, $value)
    {
        if ((bool)env('VIRUS_CHECK')) {
            return (new VirusTotalUrl(config('services.virus_total.key')))->analysis($value);
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Ссылка не прошла проверку антивируса.';
    }
}
