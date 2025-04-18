<?php

namespace app\Validator;

class RequiredValidator implements ValidatorInterface
{
    public function validate($value): bool
    {
        return !empty($value);
    }
}
