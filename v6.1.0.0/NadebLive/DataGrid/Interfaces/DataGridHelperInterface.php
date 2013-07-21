<?php

namespace NadebLive\DataGrid\Interfaces;

interface DataGridHelperInterface
{
	public function setData($data);
	public function setField($field);
	public function setPrimary($value);
	public function get();
}

