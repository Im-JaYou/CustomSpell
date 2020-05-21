<?php

namespace delnyan\spells;

use pocketmine\item\Item;
use pocketmine\Player;

abstract class SpellBase {

    private const NONE = 0;
    private const HEALTH = 1;
    private const MANA = 2;
    private const ITEM = 3;

    private const RIGHT_CLICK = 0;
    private const LEFT_CLICK = 1;
    private const AIR_LEFT_CLICK = 2;
    private const ATTACK = 3;

    private $caster = null;
    private $name = '';
    private $description = '';
    private $cost = 0;
    private $costType = 0;
    private $costItem = null;
    private $cooldown = 0;
    private $castTime = 0;
    private $castType = 0;
    private $spell = null;

    public function __construct(SpellInterface $spell, Player $caster, string $name = '', string $description = '', float $cost = 0, int $costType = 0, float $cooldown = 0, int $castType = 0, $costItem = null) {
        $this-> setSpell($spell);
        $this-> setCaster($caster);
        $this-> setName($name);
        $this-> setDescription($description);
        $this-> setCost($cost);
        $this-> setCostType($costType);
        $this-> setCooldown($cooldown);
        $this-> setCastType($castType);
        $this-> setCostItem($costItem instanceof Item ? $costItem : Item::get(0));
    }

    public function checkCooldown(): bool {
        return time() - $this-> getCastTime() >= $this-> getCooldown();
    }

    public function isEnough(): bool {
        switch($this-> getCostType()) {
            case self::NONE : return true;
            case self::HEALTH :
                return $this-> getCaster()-> getHealth() - $this-> getCost() > 0;
            case self::MANA :
                return $plugin-> getMana($this-> getCaster()) - $this-> getCost() >= 0;
            case self::ITEM :
                return $this-> getCaster()-> getInventory()-> contains($this-> getCostItem());
            default : return false;
        }
    }

    public function cast() {
        if($this-> getCaster()-> isOp())
            $this-> getSpell()-> work();
        else {
            if($this-> checkCooldown()) {
                if($this-> isEnough()) {
                    $this-> work();
                    switch($this-> getCostType()) {
                        case self::HEALTH :
                            $this-> getCaster()-> setHealth($this-> getCaster()-> getHealth() - $this-> getCost());
                            break;
                        case self::MANA :
                            $plugin-> setMana($this-> getCaster(), $plugin-> getMana($this-> getCaster()) - $this-> getCost());
                            break;
                        case self::ITEM :
                            $this-> getCaster()-> getInventory()-> remove($this-> getCostItem());
                            break;
                        default : break;
                    }
                    $this-> setCastTime(time());
                }
            }
        }
    }


    public function setSpell($spell) {
        $this-> spell = $spell;
    }

    public function getSpell() {
        return $this-> spell;
    }


    public function setCaster(Player $player) {
        $this-> caster = $player;
    }

    public function getCaster(): Player {
        return $this-> caster;
    }
    public function setName(string $name) {
        $this-> name = $name;
    }

    public function getName(): string {
        return $this-> name;
    }

    public function setDescription(string $description) {
        $this-> description = $description;
    }

    public function getDescription(): string {
        return $this-> description;
    }

    public function setCost(float $cost) {
        $this-> cost = $cost;
    }

    public function getCost(): float {
        return $this-> cost;
    }

    public function setCostType(int $costType) {
        $this-> costType = $costType;
    }

    public function getCostType(): int {
        return $this-> costType;
    }

    public function setCooldown(float $cooldown) {
        $this-> cooldown = $cooldown;
    }

    public function getCooldown(): float {
        return $this-> cooldown;
    }

    public function setCastType(int $castType) {
        $this-> castType = $castType;
    }

    public function getCastType(): int {
        return $this-> castType;
    }

    public function setCostItem(Item $item) {
        $this-> costItem = $item;
    }

    public function getCostItem(): Item {
        return $this-> costItem;
    }

    public function setCastTime(int $time) {
        $this-> castTime = $time;
    }

    public function getCastTime(): int {
        return $this-> castTime;
    }
}