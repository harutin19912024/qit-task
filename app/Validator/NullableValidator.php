<?php

namespace app\Validator;

class NullableValidator implements ValidatorInterface
{
    public function validate(mixed $value): bool
    {
        return true;
    }
}
