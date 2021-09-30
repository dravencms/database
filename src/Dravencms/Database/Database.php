<?php declare(strict_types=1);

namespace Dravencms\Database;


use Doctrine\Common\DataFixtures\SharedFixtureInterface;

class Database
{
    public $fixtures = [];

    public function addFixtureProvider(SharedFixtureInterface $class, string $name): void
    {
        $this->fixtures[$name] = $class;
    }

    public function getFixtures(): array
    {
        return $this->fixtures;
    }
}