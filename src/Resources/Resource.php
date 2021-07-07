<?php

namespace Curia\PteroSDK\Resources;

use Curia\PteroSDK\Exceptions\FieldNotPresentException;
use Curia\PteroSDK\Exceptions\FieldRequiredException;
use Curia\PteroSDK\Exceptions\FieldTypeException;
use Curia\PteroSDK\Exceptions\IncorrectAPIException;
use Curia\PteroSDK\Requester;
use Curia\PteroSDK\ResponseParser;

abstract class Resource
{
    protected $requester;
    protected $api_type;
    protected $meta;
    
    /**
     * You should not call this function directly.
     *
     * @param Requester $requester
     * @param array $data
     * @param string $api_type
     */
    public function __construct(Requester $requester, string $api_type, array $data)
    {
        $this->requester = $requester;
        $this->api_type = $api_type;

        $this->update($data);
    }

    protected function update(array $data)
    {
        $parser = new ResponseParser();

        foreach ($data['attributes'] as $key => $value) {
            $this->{$key} = $parser->parse($this->requester, $this->api_type, $value);
        }
        
        if (key_exists('meta', $data)) {
            $this->meta = $parser->parse($this->requester, $this->api_type, $data['meta']);
        }
    }

    protected function force_api_type(string $api_type)
    {
        if ($this->api_type != $api_type) {
            throw new IncorrectAPIException($api_type);
        }
    }

    protected function validate_fields(array $fields, array $rules)
    {
        foreach ($rules as $field => $field_rules) {
            foreach ($field_rules as $rule) {
                $rule_parts = explode(':', $rule);

                switch ($rule_parts[0]) {
                    case 'required':
                        // Field must exist and cannot be empty
                        if (!$this->field_exists($fields, $field) || $this->field_empty($this->get_field($fields, $field))) {
                            throw new FieldRequiredException($field);
                        }
                        break;
                    case 'present':
                        // Field must exist, can be empty
                        if (!$this->field_exists($fields, $field)) {
                            throw new FieldNotPresentException($field);
                        }
                        break;
                    case 'required_without':
                        // If other field does not exist, field must exist and cannot be empty
                        if (!$this->field_exists($fields, $rule_parts[1])) {
                            if (!$this->field_exists($fields, $field) || $this->field_empty($this->get_field($fields, $field))) {
                                throw new FieldRequiredException($field);
                            }
                        }
                        break;
                    case 'number':
                        // Field must be number, check first if it exists
                        if ($this->field_exists($fields, $field)) {
                            $value = $this->get_field($fields, $field);
                            if (!is_numeric($value) && !is_null($value)) {
                                throw new FieldTypeException($field, 'number');
                            }
                        }
                        break;
                    case 'boolean':
                        // Field must be number, check first if it exists
                        if ($this->field_exists($fields, $field)) {
                            $value = $this->get_field($fields, $field);
                            if (!is_bool($value) && !is_null($value)) {
                                throw new FieldTypeException($field, 'boolean');
                            }
                        }
                        break;
                    case 'string':
                        // Field must be string, check first if it exists
                        if ($this->field_exists($fields, $field)) {
                            $value = $this->get_field($fields, $field);
                            if (!is_string($value) && !is_null($value)) {
                                throw new FieldTypeException($field, 'string');
                            }
                        }
                        break;
                    case 'object':
                        // Field must be number, check first if it exists
                        if ($this->field_exists($fields, $field)) {
                            $value = $this->get_field($fields, $field);
                            if (!is_array($value) && !is_null($value)) {
                                throw new FieldTypeException($field, 'associative array');
                            }
                        }
                        break;
                    case 'number_or_string':
                        // Field must be string, check first if it exists
                        if ($this->field_exists($fields, $field)) {
                            $value = $this->get_field($fields, $field);
                            if (!is_string($value) && !is_numeric($value) && !is_null($value)) {
                                throw new FieldTypeException($field, 'number or string');
                            }
                        }
                        break;
                    default:
                        break;
                }
            }
        }
    }

    private function field_exists(array $fields, string $field)
    {
        if ($field.contains('.')) {
            $keys = explode('.', $field);

            $temp = $fields;
            for ($i = 0; $i < count($keys); $i++) { 
                if (key_exists($keys[$i], $temp)) {
                    if ($i < count($keys) - 1) {
                        $temp = $temp[$keys[$i]];
                    }
                } else {
                    return false;
                }
            }

            return true;
        } else {
            return key_exists($field, $fields);
        }
    }

    private function get_field(array $fields, string $field)
    {
        if ($field.contains('.')) {
            $keys = explode('.', $field);

            $temp = $fields;
            for ($i = 0; $i < count($keys) - 1; $i++) { 
                $temp = $temp[$keys[$i]];
            }

            return $temp[end($keys)];
        } else {
            return $fields[$field];
        }
    }

    private function field_empty($value)
    {
        if (is_string($value) && strlen($value) <= 0) {
            return true;
        }
        return is_null($value);
    }

    /**
     * Returns objects "meta" object, or null if it doesn't exist.
     *
     * @return array|null
     */
    public function meta()
    {
        return $this->meta ?? null;
    }
}
