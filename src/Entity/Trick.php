<?php

namespace App\Entity;

use App\Traits\FromArrayTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Trick
 *
 * @ORM\Table(name="trick", uniqueConstraints={@ORM\UniqueConstraint(name="name_UNIQUE", columns={"name"})}, indexes={@ORM\Index(name="fk_Trick_Group1_idx", columns={"group_id"})})
 * @ORM\Entity(repositoryClass="App\Repository\TrickRepository")
 * @UniqueEntity("name")
 */
class Trick
{
    use FromArrayTrait;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=3000, nullable=false)
     * @Assert\Length(max=3000, maxMessage="Vous avez dépassé le nombre de caractères maximum pour la description (3000)")
     */
    private $description;

    /**
     * @var $group Group
     *
     * @ORM\ManyToOne(targetEntity="Group")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="group_id", referencedColumnName="id")
     * })
     */
    private $group;

    /**
     * @var ArrayCollection
     * @ORM\Column(nullable=true)
     * @ORM\OneToMany(targetEntity="Post", mappedBy="trick", cascade={"remove"})
     */
    private $posts;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="TrickImage", mappedBy="trick", cascade={"persist", "remove"})
     */
    private $trickImages;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Video", mappedBy="trick", cascade={"persist", "remove"})
     */
    private $videos;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
        $this->trickImages = new ArrayCollection();
        $this->videos = new ArrayCollection();
    }

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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return Group
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @param Group $group
     */
    public function setGroup($group)
    {
        $this->group = $group;
    }

    /**
     * @param ArrayCollection $posts
     */
    public function setPosts($posts)
    {
        $this->posts = $posts;
    }

    /**
     * @return ArrayCollection
     */
    public function getPosts()
    {
        return $this->posts;
    }

    /**
     * @param Post $post
     */
    public function addPost(Post $post)
    {
        $this->posts->add($post);
    }

    /**
     * @param Post $post
     */
    public function removePost(Post $post)
    {
        $this->posts->removeElement($post);
    }

    /**
     * @param $trickImages ArrayCollection
     */
    public function setTrickImages($trickImages)
    {
        $this->trickImages = $trickImages;
    }

    /**
     * @return ArrayCollection
     */
    public function getTrickImages()
    {
        return $this->trickImages;
    }

    /**
     * @param TrickImage $trickImage
     */
    public function addTrickImage(TrickImage $trickImage)
    {
        $this->trickImages->add($trickImage);
        $trickImage->setTrick($this);
    }

    /**
     * @param TrickImage $trickImage
     */
    public function removeTrickImage(TrickImage $trickImage)
    {
        $this->trickImages->removeElement($trickImage);
    }

    /**
     * @param ArrayCollection $videos
     */
    public function setVideos($videos)
    {
        $this->videos = $videos;
    }

    /**
     * @return ArrayCollection
     */
    public function getVideos()
    {
        return $this->videos;
    }

    /**
     * @param Video $video
     */
    public function addVideo(Video $video)
    {
        $this->videos->add($video);
    }

    /**
     * @param Video $video
     */
    public function removeVideo(Video $video)
    {
        $this->videos->removeElement($video);
    }
}

