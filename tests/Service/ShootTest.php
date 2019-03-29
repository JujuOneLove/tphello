<?php
namespace App\Tests\Service;


use App\Entity\Game;

use App\Service\Shoot;
use PHPUnit\Framework\TestCase;

class ShootTest extends TestCase{


    /**
     * @expectedException \InvalidArgumentException
     */
    public function testScoreWithoutBet(){

        $shoot = new Shoot();

        $this->assertEquals(0, $shoot->shoot());
    }

    public function testKill(){

        $game = new Game();
        $game->setAssassination(0);
        $shoot = new Shoot();

        $this->assertEquals(1, $shoot->kill($game));
    }

    public function testDamage(){

        $game = new Game();
        $game->setDamage(0);
        $shoot = new Shoot();

        $this->assertEquals(100, $shoot->damage($game));
    }

    public function testKillShoot(){
        $game = new Game();
        $game->setAssassination(0);
        $game->setDamage(0);
        $shoot = new Shoot();
        $aftershoot= $shoot->shoot($game, 10);
        $this->assertEquals(1, $aftershoot->getAssassination());
    }
    public function testKillDamageShoot(){
        $game = new Game();
        $game->setAssassination(0);
        $game->setDamage(0);
        $shoot = new Shoot();
        $aftershoot= $shoot->shoot($game, 10);
        $this->assertEquals(100, $aftershoot->getDamage());
    }
    public function testDamageShoot(){
        $game = new Game();
        $game->setAssassination(0);
        $game->setDamage(0);
        $shoot = new Shoot();
        $aftershoot= $shoot->shoot($game, 30);
        $this->assertEquals(100, $aftershoot->getDamage());
    }
    public function testNothingKillShoot(){
        $game = new Game();
        $game->setAssassination(0);
        $game->setDamage(0);
        $shoot = new Shoot();
        $aftershoot= $shoot->shoot($game, 80);
        $this->assertEquals(0, $aftershoot->getAssassination());
    }
    public function testNothingDamageShoot(){
        $game = new Game();
        $game->setAssassination(0);
        $game->setDamage(0);
        $shoot = new Shoot();
        $aftershoot= $shoot->shoot($game, 80);
        $this->assertEquals(0, $aftershoot->getDamage());
    }
}
