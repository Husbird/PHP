<?php

require_once "player.php"; //внутри реализовать class Player
require_once "tournament.php"; //внутри реализовать класс Tournament

$tournamentA = new Tournament("Tournament А", "2022.12.30");
$tournamentA
    ->addPlayer( (new Player("Player 1"))->setCity("Minsk") )
    ->addPlayer( (new Player("Player 2"))->setCity("Mogilev") )
    ->addPlayer( (new Player("Player 3"))->setCity("Vitebsk") )
    ->addPlayer( (new Player("Player 4"))->setCity("Gomel") );
$tournamentA->createPairs();
/*
ожидаемый результат выполнения $tournamentA->createPairs();
Примечание. Все пары уникальные.
Tournament А, 31.12.2022
Player 1 (Minsk) - Player 4 (Gomel)
Player 2 (Mogilev) - Player 3 (Vitebsk)
Tournament А, 01.01.2023
Player 1 (Minsk) - Player 3 (Vitebsk)
Player 4 (Gomel) - Player 2 (Mogilev)
Tournament А, 02.01.2023
Player 1 (Minsk) - Player 2 (Mogilev)
Player 3 (Vitebsk) - Player 4 (Gomel)
*/
$tournamentB = new Tournament("Tournament B");
$tournamentB
    ->addPlayer( new Player("Player 1" ) )
    ->addPlayer( new Player("Player 2" ) )
    ->addPlayer( new Player("Player 3" ) )
    ->addPlayer( new Player("Player 4" ) )
    ->addPlayer( new Player("Player 5") )
    ->addPlayer( new Player("Player 6") )
    ->addPlayer( new Player("Player 7") );

$tournamentB->createPairs();

/*
ожидаемый результат выполнения $tournamentB->createPairs();
Примечание. Все пары уникальные. В каждом туре есть одна игрок его пропускающий. Например, в первом туре это Player 1. Дата в примерах ниже из расчете, что сегодня 04.05.2022
Tournament B, 05.05.2022
Player 2 - Player 7
Player 3 - Player 6
Player 4 - Player 5
Tournament B, 06.05.2022
Player 1 - Player 7
Player 2 - Player 5
Player 3 - Player 4
Tournament B, 07.05.2022
Player 1 - Player 6
Player 7 - Player 5
Player 2 - Player 3
Tournament B, 08.05.2022
Player 1 - Player 5
Player 6 - Player 4
Player 7 - Player 3
Tournament B, 09.05.2022
Player 1 - Player 4
Player 5 - Player 3
Player 6 - Player 2
Tournament B, 10.05.2022
Player 1 - Player 3
Player 4 - Player 2
Player 6 - Player 7
Tournament B, 11.05.2022
Player 1 - Player 2
Player 4 - Player 7
Player 5 - Player 6
*/
