<?php

namespace App\Entity;

use App\Upload\Image;
use Doctrine\ORM\Mapping as ORM;

/**
 * TrickImage
 *
 * @ORM\Table(name="trick_image", indexes={@ORM\Index(name="fk_TrickImage_Trick1_idx", columns={"trick_id"})})
 * @ORM\Entity
 */
class TrickImage extends Image
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
     * @var Trick
     *
     * @ORM\ManyToOne(targetEntity="Trick", inversedBy="trickImages")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="trick_id", referencedColumnName="id")
     * })
     */
    private $trick;

    /**
     * @return int
     * @codeCoverageIgnore
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Trick
     */
    public function getTrick()
    {
        return $this->trick;
    }

    /**
     * @param Trick $trick
     */
    public function setTrick($trick)
    {
        $this->trick = $trick;
        $trick->addTrickImage($this);
    }

}

