<?php

namespace weapons;

abstract class automatons {
	abstract public function shoot(\ammo $ammo) : \sleeve;
	abstract public function reloud(\magazine $magazine) : \magazine;
}