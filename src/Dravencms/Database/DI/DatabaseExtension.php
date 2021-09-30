<?php declare(strict_types=1);

namespace Dravencms\Base\DI;



use Doctrine\Common\DataFixtures\SharedFixtureInterface;
use Dravencms\Database\Database;
use Nette\DI\CompilerExtension;
use Nette\DI\Definitions\ServiceDefinition;

/**
 * Class BaseExtension
 * @package Dravencms\Structure\DI
 */
class BaseExtension extends CompilerExtension
{
    protected static $prefix = 'database';

    public function loadConfiguration(): void
    {
        $builder = $this->getContainerBuilder();
        $builder->addDefinition($this->prefix(self::$prefix))
            ->setFactory(Database::class);

        $this->loadConsole();
    }

    public function beforeCompile(): void
    {
        $builder = $this->getContainerBuilder();

        /** @var ServiceDefinition $database */
        $database = $builder->getDefinition($this->prefix(self::$prefix));

        foreach ($builder->findByType(SharedFixtureInterface::class) AS $serviceName => $service) {
            $database->addSetup('addFixtureProvider', ['@' . $serviceName, $serviceName]);
        }
    }

    protected function loadConsole(): void
    {
        $builder = $this->getContainerBuilder();

        foreach ($this->loadFromFile(__DIR__ . '/console.neon') as $i => $command) {
            $cli = $builder->addDefinition($this->prefix('cli.' . $i))
                ->setAutowired(false);

            if (is_string($command)) {
                $cli->setFactory($command);
            } else {
                throw new \InvalidArgumentException;
            }
        }
    }
}
