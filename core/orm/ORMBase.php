<?php

namespace core\orm;

class ORMBase
{
	protected $sql;

	protected $where = [];

	Protected $order = [];

	protected $limit;

	protected $offset;

	public static function query()
	{
		$query = new static();
		return $query;
	}

	public function get()
	{
		$this->sql = "SELECT * FROM " . $this->getTableName();
		if (!empty($this->where)) {
			$cond = implode(" AND ", $this->where);
			$this->sql .= " WHERE " . $cond;
		}

		if (!empty($this->order)) {
			$cond = implode(", ", $this->order);
			$this->sql .= " ORDER BY " . $cond;
		}

		if (!empty($this->limit)) {
			$this->sql .= " LIMIT " . $this->limit;
		}

		if (!empty($this->offset)) {
			$this->sql .= " OFFSET " . $this->offset;
		}
		return $this->executeStatemant();
	}

	public function getTableName()
	{
		$class = get_called_class();
		$parts = explode('\\', $class);
		return strtolower($parts[count($parts) - 1]);
	}

	public function where($column, $operator, $value)
	{
		if (is_string($value)) {
			$value = "\"$value\"";
		} else if (is_array($value)) {
			foreach ($value as $index => $v) {
				if (is_string($v)) {
					$value[$index] = "\"$v\"";
				}
			}
			$value = "(" . implode(',', $value) . ")";
		}

		$this->where = "$column $operator $value";
		return $this;
	}

	public function limit($value)
	{
		$this->limit = $value;
		return $this;
	}

	public function offset($value)
	{
		$this->offset = $value;
		return $this;
	}

	public function orderBy($column, $direction)
	{
		$this->order[] = "$column $direction";
		return $this;
	}

	public function create($attributes)
	{
		$table = $this->getTableName();
		if (empty($attributes['created_at'])) {
			$attributes['created_at'] = date('Y-m-d H:i:s');
		}

		if (empty($attributes['updated_at'])) {
			$attributes['updated_at'] = date('Y-m-d H:i:s');
		}

		$columns = implode(', ', array_keys($attributes));
		$values = implode(', ', array_map(function($item) {
			return "\"$item\"";
		}, $attributes));
		$this->sql = "INSERT INTO $table ($columns) VALUES $values";
		return $this->executeStatemant();
	}

	public function executeStatemant()
	{
		return get_connection()->query($this->sql);
	}
}