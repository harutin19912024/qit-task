<?php
namespace app\Validator;

interface ValidatorInterface
{
    public function validate($value): bool;
}
