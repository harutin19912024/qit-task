<?php

namespace app\Validator;

class Validator
{
    private array $validators = [];
    private array $errors = [];
    private array $data;
    private array $rules;

    public function __construct(array $data = [], array $rules = [])
    {
        $this->validators = [
            'required' => new RequiredValidator(),
            'uuid' => new UuidValidator(),
            'email' => new EmailValidator(),
            'string' => new StringValidator(),
            'nullable' => new NullableValidator(),
        ];

        $this->data = $data;
        $this->rules = $rules;
    }

    /**
     * @return bool
     */
    public function passes(): bool
    {
        $this->errors = $this->validate($this->data, $this->rules);
        return empty($this->errors);
    }

    /**
     * @return array
     */
    public function errors(): array
    {
        return $this->errors;
    }

    /**
     * @param string $rule
     * @param ValidatorInterface $validator
     * @return void
     */
    public function registerValidator(string $rule, ValidatorInterface $validator): void
    {
        $this->validators[$rule] = $validator;
    }

    /**
     * @param array $data
     * @param array $rules
     * @return array
     */
    public function validate(array $data, array $rules): array
    {
        $errors = [];

        foreach ($rules as $field => $ruleSet) {
            foreach ($ruleSet as $rule) {
                if (isset($this->validators[$rule])) {
                    $validator = $this->validators[$rule];
                    if (! $validator->validate($data[$field] ?? null)) {
                        $errors[$field][] = "The {$field} field is invalid for rule {$rule}.";
                    }
                } else {
                    $errors[$field][] = "The rule {$rule} is not supported.";
                }
            }
        }

        return $errors;
    }
}
