<?php
namespace App\Tests\Service\Bet;

use App\Entity\Bet;
use App\Entity\Game;

use App\Service\Bet\GainIsWon;
use App\Service\Bet\BetIsWon;
use PHPUnit\Framework\TestCase;

class GainIsWonTest extends TestCase{


    /**
    * @expectedException \InvalidArgumentException
    */
    public function testScoreWithoutBet(){

        $betWin = new BetIsWon();
        $gain = new GainIsWon($betWin);
        $this->assertEquals(10, $gain->gain());
    }
    public function testScoreExacte0vs0(){

        $bet = new Bet();
        $bet->setScoreTeamA(0);
        $bet->setScoreTeamB(0);
        $bet->setAmout(5);
        $game = new Game();
        $game->setScoreTeamA(0);
        $game->setScoreTeamB(0);
        $bet->setGame($game);
        $betWin = new BetIsWon();
        $gain = new GainIsWon($betWin);

        $this->assertEquals(15, $gain->gain($bet));
    }
    public function testScoreEquipeWin(){

        $bet = new Bet();
        $bet->setScoreTeamA(5);
        $bet->setScoreTeamB(2);
        $bet->setAmout(20);
        $game = $this->createMock(Game::class);
        $game->expects($this->any())
            ->method('getScoreTeamA')
            ->willReturn(5);
        $game->expects($this->any())
            ->method('getScoreTeamB')
            ->willReturn(0);
        $bet->setGame($game);
        $betWin = new BetIsWon();
        $gain = new GainIsWon($betWin);

        $this->assertEquals(20, $gain->gain($bet));
    }
    public function testScoreEquipeWinLose2(){

        $bet = $this->createMock(Bet::class);
        $bet->expects($this->any())
            ->method('getScoreTeamA')
            ->willReturn(1);
        $bet->expects($this->any())
            ->method('getScoreTeamB')
            ->willReturn(0);
        $bet->expects($this->any())
            ->method('getAmout')
            ->willReturn(10);
        $game = $this->createMock(Game::class);
        $game->expects($this->any())
            ->method('getScoreTeamA')
            ->willReturn(0);
        $game->expects($this->any())
            ->method('getScoreTeamB')
            ->willReturn(2);
        $bet->expects($this->any())
            ->method('getGame')
            ->willReturn($game);
        $betWin = new BetIsWon();
        $gain = new GainIsWon($betWin);

        $this->assertEquals(-10, $gain->gain($bet));
    }

}