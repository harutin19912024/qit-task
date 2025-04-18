<?php

namespace app\Validator;

class StringValidator implements ValidatorInterface
{
    public function validate(mixed $value): bool
    {
        return is_string($value);
    }
}
