<?php


class Tournament
{
    private $name;
    private $startDate;
    private $players = [];

    private $resultPairs = []; //все возможные пары
    private $playedGames = []; //список уже отыгравших пар

    public function __construct($name, $startDate = false) {
        $this->name = trim($name);
        if (!$startDate) {
            $startDate = strtotime("+1 day");
            $this->startDate = date("Y.m.d", $startDate);
            return;
        }
        $this->startDate = trim($startDate);

    }

    public function addPlayer($team) {
        $this->players[] = $team;
        return $this;
    }

    public function createPairs() {
        //добавляем заглушку если нужно
        if (count($this->players) % 2 > 0) {
            $this->players[] = "#";
        }
        //инициализация массива всех возможных пар ($this->resultPairs)
        $this->pairsInit();
        //подготовка и вывод турниров
        $currentDate = $this->startDate;
        //с каждым турниром (итерацией) массив $this->resultPairs сокращается на уже отыгравшие в турнире пары
        while (count($this->resultPairs)) {
            echo $this->name . ", " . $currentDate . "<br>";
            $pairs = $this->getTournament();
            foreach ($pairs as $val) {
                $players = explode("|", $val);
                $player1 = $this->players[$players[0]];
                $player2 = $this->players[$players[1]];
                echo $player1->getName() . " ". $player1->getCity() ." - "
                    . $player2->getName() . " " . $player2->getCity() . "<br>";
            }
            //обновляю дату (увеличиваю на 1 день)
            $date = str_replace(".", "-", $currentDate);
            $timestamp = strtotime($date);
            $currentDate = date("Y.m.d", strtotime("+1 day", $timestamp));
        }
    }

    /*Проверка пары на уникальность (на отсутствие в массиве $arr).
      Если уникальна возвращает true, иначе false */
    private function isUniqPair($pairStr, $arr):bool {
        if ( in_array($pairStr, $arr, true) || in_array(strrev($pairStr), $arr, true) ) {
            return false;
        }
        return true;
    }

    /*получаем все возможные уникальные пары (инициализация массива $this->resultPairs) */
    private function pairsInit() {
        $tempBuffer = []; //уже имеющиеся пары (с дубликатами)
        for ($i = 0; $i < count($this->players); $i++) {
            for ($j = 0; $j < count($this->players); $j++) {
                if ($i === $j) continue;
                $pair = $i."|".$j;
                if ($this->isUniqPair($pair, $tempBuffer)) {
                    $this->resultPairs[] = $pair;
                    $tempBuffer[] = $pair;
                }
            }
        }
    }

    /*Возвращает массив пар играющих в текущем турнире, а также удаляет эти пары из общего
      массива пар ($this->resultPairs) */
    private function getTournament():array {
        $todayPlayed = []; //отыгравшие в текущем турнире игроки
        $currentPairs = []; //играющие в текущем турнире пары
        //перебор массива всех возможных пар
        foreach ($this->resultPairs as $val) {
            $arr = explode("|", $val);
            $p1 = $arr[0];
            $p2 = $arr[1];
            //проверка на участие в текущем турние
            if ( in_array($p1, $todayPlayed, true) || in_array($p2, $todayPlayed, true) ) {
                continue;
            }
            //пополняю список уже отыгравших пар
            $this->playedGames[] = $val;
            //проверяем заглушку
            if ($this->players[$p1] === "#" || $this->players[$p2] === "#") continue;
            //отмечаю игроков как уже играющих "сегодня"
            $todayPlayed[] = $p1;
            $todayPlayed[] = $p2;
            //добавляю текущую пару в турнир
            $currentPairs[] = $val;
        }
        //удаляем отыгравшие в турнирах пары из общего массива возможных пар ($this->resultPairs)
        $this->resultPairs = array_diff($this->resultPairs , $this->playedGames);
        return $currentPairs;
    }
}