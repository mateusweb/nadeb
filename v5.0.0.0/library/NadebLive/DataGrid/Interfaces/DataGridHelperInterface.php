<?php
interface DataGridHelperInterface
{
	public function setData(array $data);
	public function setField($field);
	public function setPrimary($value);
	public function get();
}

