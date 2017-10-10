<?php

namespace App\Entity;

use App\Traits\FromArrayTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * Video
 *
 * @ORM\Table(name="video", indexes={@ORM\Index(name="fk_Video_Trick1_idx", columns={"Trick_id"})})
 * @ORM\Entity(repositoryClass="App\Repository\VideoRepository")
 */
class Video
{
    use FromArrayTrait;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="source_id", type="string", length=45, nullable=false)
     */
    private $sourceId;

    /**
     * @var Trick
     *
     * @ORM\ManyToOne(targetEntity="Trick", inversedBy="videos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Trick_id", referencedColumnName="id")
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
     * @return string
     */
    public function getSourceId()
    {
        return $this->sourceId;
    }

    /**
     * @param string $sourceId
     */
    public function setSourceId($sourceId)
    {
        $this->sourceId = $sourceId;
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
        $trick->addVideo($this);
    }

}

