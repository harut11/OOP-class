<?php

namespace weapons;

abstract class pistols extends weapons {
	abstract public function shoot(\ammo $ammo) : \sleeve;
	abstract public function reloud(\magazine $magazine) : \magazine;
}