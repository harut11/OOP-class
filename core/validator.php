<?php

namespace core;

class validator
{
	private $errors = [];

	public function make($request_data, $rules)
	{
		foreach ($request_data as $field => $value) {
			if (isset($rules[$field])) {
				$fieldErrors = $this->validateField($field, $rules[$field], $request_data);
				if (empty($fieldErrors)) {
					$this->$errors[$field] = $fieldErrors;
				}
			}
		}

		return $this;
	}

	protected function validateField(string $field, string $rules, array $data) : array
	{
		$rules = explode('|', $rules);
		$errors = [];
		foreach ($rules as $rule) {
			$rullWithAttributes = explode(':', $rule);
			$rullName = $rullWithAttributes[0];
			$attributes = count($rullWithAttributes) > 1 ? explode(',', $rullWithAttributes[1]) : [];
			$success = $this->validateFieldRule($field, $rullName, $attributes, $data);
			if (!$success) {
				$errors[] = $this->getErrorMessage($field, $rullName, $attributes);
			}
		}
		return $errors;
	}

	protected function validateFieldRule(string $field, string $ruleName, array $attributes, array $data) : bool
	{
		switch ($ruleName) {
			case 'required':
				return !empty($data[$field]);
				break;
			case 'min':
				return isset($data[$field]) && strlen($data[$field]) >= $attributes[0];
				break;
			case 'max':
				return isset($data[$field]) && strlen($data[$field]) <= $attributes[0];
				break;
			case 'email':
				$pattern = "/\b[\w\.-]+@[\w\.-]+\.\w{2,4}\b/";
				preg_match($pattern, $data[$field], $matches);
				return count($matches) > 0;
				break;
			case 'phone':
				$pattern = "/\+(9[976]\d|8[987530]\d|6[987]\d|5[90]\d|42\d|3[875]\d|2[98654321]\d|9[8543210]|8[6421]|6[6543210]|5[87654321]|4[987654310]|3[9643210]|2[70]|7|1)\d{1,14}$/";
				preg_match($pattern, $data[$field], $matches);
				return count($matches) > 0;
				break;
			case 'confirmed':
				return isset($data[$field]) && isset($data['confirm_' . $field]) && $data[$field] == $data['confirm_' . $field];
				break;
			case 'unique':
				$table = $attributes[0];
				$column = $attributes[1];
				$value = $data[$field];
				$sql = "SELECT count(id) AS count FROM $table WHERE $column = '$value'";
				$result = get_connection()->query($sql);
				return !$result[0]['count'];
				break;
			
			default:
				return true;
				break;
		}
	}

	protected function getErrorMessage(string $field, string $rule, array $attributes) : string
	{
		$messages = [
			'required' => "The field :field id required",
			'min' => "The field :field must be at least :attribute characters long",
			'max' => "The field :field must be no longer than :attribute characters long",
			'email' => "The field :field is not a valid email address",
			'phone' => "The field :field is not a valid phone number",
			'confirmed' => "The :field confirmation does not match",
			'unique' => "The :field is already in use"
		];

		if (isset($messages[$rule])) {
			$message = $messages[$rule];
			$message = str_replace(':field', $field, $message);
			if (!empty($attributes)) {
				$message = str_replace(':attribute', $attributes[0], $message);
			}
			return $message;
		}
	}


	public function getErrors()
	{
		return !empty($this->errors) ? $this->errors : false;
	}
}