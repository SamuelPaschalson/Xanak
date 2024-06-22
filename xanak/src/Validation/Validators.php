<?php

namespace Xanak\Validation;

class Validators
{
    public function validate($data, $rules)
    {
        $errors = [];
        foreach ($rules as $field => $rule) {
            if (!preg_match($rule, $data[$field])) {
                $errors[$field] = "Invalid format for $field";
            }
        }
        return $errors;
    }
}
