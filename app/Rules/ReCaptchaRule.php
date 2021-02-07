<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use ReCaptcha\ReCaptcha;

class ReCaptchaRule implements Rule
{

    private $error_msg = '';

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (empty($value)) {
            $this->error_msg = ':attribute field is requireds.';

            return false;
        }

        $recaptcha = new ReCaptcha(env('GOOGLE_RECAPTCHA_SECRET_KEY'));

        $resp = $recaptcha->setExpectedHostname($_SERVER['SERVER_NAME'])
            ->setScoreThreshold(0.5)
            ->verify($value, $_SERVER['REMOTE_ADDR']);

        if (app()->environment(['production'])) {

            if (!$resp->isSuccess()) {
                $this->error_msg = 'ReCaptcha field is required.';

                return false;
            }

            if ($resp->getScore() < 0.5) {
                $this->error_msg = 'Failed to validate captcha.';

                return false;
            }
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
        return $this->error_msg;

    }
}
