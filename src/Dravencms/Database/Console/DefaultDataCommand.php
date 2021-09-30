<?php

namespace Dravencms\Database\Console;


use Dravencms\Database\Database;
use Dravencms\Database\EntityManager;
use Symfony\Component\Console\Command\Command;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Copyright (C) 2016 Adam Schubert <adam.schubert@sg1-game.net>.
 */
class DefaultDataCommand extends Command
{
    /** @var string */
    protected static $defaultName = 'orm:default-data:load';

    /** @var string */
    protected static $defaultDescription = 'Load data fixtures to your database.';

    /** @var EntityManager @inject */
    public $em;

    /** @var Database @inject */
    public $database;


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $loader = new Loader();
            foreach ($this->database->getFixtures() as $fixture)
            {
                $loader->addFixture($fixture);
            }

            $fixtures = $loader->getFixtures();
            $purger = new ORMPurger($this->em);
            $executor = new ORMExecutor($this->em, $purger);
            $executor->setLogger(function ($message) use ($output) {
                $output->writeln(sprintf('  <comment>></comment> <info>%s</info>', $message));
            });
            $executor->execute($fixtures);
            return 0; // zero return code means everything is ok
        } catch (\Exception $exc) {
            $output->writeLn("<error>{$exc->getMessage()}</error>");
            return 1; // non-zero return code means error
        }
    }
}