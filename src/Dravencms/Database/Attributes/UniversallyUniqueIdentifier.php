<?php declare(strict_types = 1);
/**
 * Created by PhpStorm.
 * User: sadam
 * Date: 10/13/21
 * Time: 2:25 AM
 */

namespace Dravencms\Database\Attributes;

use Doctrine\ORM\Mapping as ORM;

trait UniversallyUniqueIdentifier
{
    /**
     * @ORM\Id
     * @ORM\Column(type="guid")
     * @ORM\GeneratedValue(strategy="UUID")
     * @var string
     */
    private $id;



    /**
     * @return string
     */
    final public function getId(): string
    {
        return $this->id;
    }



    public function __clone()
    {
        $this->id = NULL;
    }
}