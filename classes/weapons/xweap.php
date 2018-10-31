<?php

namespace weapons;

class xweap extends weapons {
	final public function shoot(\ammo $ammo) : \sleeve 
	{
		echo 'Shooting';
		return new \sleeve;
	}
	final public function reloud(\magazine $magazine) : \magazine 
	{
		echo 'Relouding';
		return new \sleeve;
	}
}