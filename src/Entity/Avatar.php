<?php

namespace App\Entity;

use App\Upload\Image;
use Doctrine\ORM\Mapping as ORM;

/**
 * Avatar
 *
 * @ORM\Table(name="avatar")
 * @ORM\Entity(repositoryClass="App\Repository\AvatarRepository")
 */
class Avatar extends Image
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @return int
     * @codeCoverageIgnore
     */
    public function getId()
    {
        return $this->id;
    }
}