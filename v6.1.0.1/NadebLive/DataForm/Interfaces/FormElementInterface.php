<?php
namespace NadebLive\DataForm\Interfaces;

interface FormElementInterface
{
	public function getType();
	public function getName();
	public function getElement();
	public function getLabel();
}

