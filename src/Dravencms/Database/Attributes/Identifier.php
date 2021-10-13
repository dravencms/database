<?php declare(strict_types = 1);
/**
 * Created by PhpStorm.
 * User: sadam
 * Date: 10/13/21
 * Time: 2:26 AM
 */

namespace Dravencms\Database\Attributes;

use Doctrine\ORM\Mapping as ORM;

trait Identifier
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @var integer|null
     */
    private $id;



    /**
     * @return integer
     */
    final public function getId(): int
    {
        return $this->id;
    }



    public function __clone()
    {
        $this->id = NULL;
    }

}