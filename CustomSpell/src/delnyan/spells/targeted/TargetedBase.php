<?php

namespace delnyan\spells\targeted;

use pocketmine\entity\Entity;

class TargetedBase {

    private $target = null;

    public function __construct(Entity $target) {
        $this-> setTarget($target);
    }

    public function setTarget(Entity $target) {
        $this-> target = $target;
    }

    public function getTarget(): Entity {
        return $this-> target;
    }
}
