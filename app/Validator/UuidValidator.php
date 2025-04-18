<?php

namespace app\Validator;

class UuidValidator implements ValidatorInterface
{
    public function validate($value): bool
    {
        return preg_match('/^[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}$/', $value) === 1;
    }
}
