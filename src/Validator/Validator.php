<?php

namespace App\Validator;

use App\Databases\DB;

class Validator
{
    public array $rules;

    public function __construct()
    {
    }

    public function validate($data)
    {
        $result = [];
        $prepareData = $this->prepareData($data);
        foreach ($prepareData as $key => $value) {
            $rulesForValue = $this->rules[$key];
            $rules = explode("|", $rulesForValue);
            foreach ($rules as $rule) {
                if (str_contains($rule, 'match:')) {
                    $ruleMatch = explode(':', $rule);
                    $result = [...$result, self::match($key, $value, $prepareData[$ruleMatch[1]])];
                } else {
                    $callable = [self::class, $rule];
                    $result = [...$result, $callable($key, $value)];
                }

            }
        }
        return array_filter($result);
    }

    public function setRules(array $rules)
    {
        $this->rules = $rules;
    }

    private static function require($key, $value)
    {
        if ($value === '') {
            return "Field \"{$key}\" must not be empty!";
        }
        return '';
    }

    private static function unique($key, $value)
    {
        $db = new DB('users');
        $dbData = $db->search($key, $value);
        if ($dbData !== null) {
            return "This data \"{$key}\" is already in use in another account!";
        }
        return '';
    }

    private static function match($key, $value, $matchValue)
    {
        if ($value !== $matchValue) {
            return "Values \"{$key}\" do not match!";
        }

        return '';
    }

    private function prepareData($data)
    {
        $keys = array_keys($this->rules);
        return array_filter($data, fn ($key) => in_array($key, $keys, true), ARRAY_FILTER_USE_KEY);
    }
}
