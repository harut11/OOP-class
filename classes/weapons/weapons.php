<?php

namespace weapons;

abstract class weapons {
	abstract public function shoot(\ammo $ammo) : \sleeve;
	abstract public function reloud(\magazine $magazine) : \magazine;
}