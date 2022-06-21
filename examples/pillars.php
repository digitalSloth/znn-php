<?php

$znn = new \DigitalSloth\ZnnPhp\Zenon();

$znn->pillar->getQsrRegistrationCost();
$znn->pillar->checkNameAvailability('test');
$znn->pillar->getAll();
$znn->pillar->getByOwner('address');
$znn->pillar->getByName('name');
$znn->pillar->getDelegatedPillar('address');
$znn->pillar->getDepositedQsr('address');
$znn->pillar->getUncollectedReward('address');
$znn->pillar->getFrontierRewardByPage('address', 0, 20);
$znn->pillar->getFrontierRewardByPage('address', 0, 20);
