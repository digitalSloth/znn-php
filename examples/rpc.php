<?php

$znn = new \DigitalSloth\ZnnPhp\Zenon('127.0.0.1:35997');

$results = $znn->pillar->getQsrRegistrationCost();
$results = $znn->pillar->checkNameAvailability('test');
$results = $znn->pillar->getAll();
$results = $znn->pillar->getByOwner('address');
$results = $znn->pillar->getByName('name');
$results = $znn->pillar->getDelegatedPillar('address');
$results = $znn->pillar->getDepositedQsr('address');
$results = $znn->pillar->getUncollectedReward('address');
$results = $znn->pillar->getFrontierRewardByPage('address', 0, 20);
$results = $znn->pillar->getFrontierRewardByPage('address', 0, 20);
