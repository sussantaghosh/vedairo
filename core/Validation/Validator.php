<?php
namespace Vedairo\Validation;

class Validator {
    /** @var array<string,string> */
    public array $errors = [];

    /**
     * @param array<string,mixed> $data
     * @param array<string,string> $rules
     */
    public function __construct(private array $data, private array $rules) {}

    public function validate(): bool {
        foreach ($this->rules as $field => $rules) {
            $v = $this->data[$field] ?? null;
            foreach (explode('|', $rules) as $rule) {
                [$name, $arg] = array_pad(explode(':', $rule, 2), 2, null);
                $bad = match ($name) {
                    'required' => ($v === null || $v === '' || (is_array($v) && count($v) === 0)),
                    'email' => ($v !== null && $v !== '' && filter_var($v, FILTER_VALIDATE_EMAIL) === false),
                    'min' => is_string($v) ? (strlen($v) < (int)$arg) : (is_numeric($v) && (float)$v < (float)$arg),
                    'max' => is_string($v) ? (strlen($v) > (int)$arg) : (is_numeric($v) && (float)$v > (float)$arg),
                    'integer' => ($v !== null && $v !== '' && filter_var($v, FILTER_VALIDATE_INT) === false),
                    'numeric' => ($v !== null && $v !== '' && !is_numeric($v)),
                    'string' => ($v !== null && !is_string($v)),
                    'array' => ($v !== null && !is_array($v)),
                    default => false
                };
                if ($bad) {
                    $this->errors[$field] = "$field failed $name validation";
                    break;
                }
            }
        }
        return empty($this->errors);
    }

    /**
     * @return array<string,string>
     */
    public function errors(): array {
        return $this->errors;
    }
}

