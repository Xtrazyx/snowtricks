<?php

namespace App\Upload;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Image
 * @package App\Upload
 */
abstract class Image
{
    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255, nullable=true)
     */
    protected $url;

    /**
     * @var string
     *
     * @ORM\Column(name="alt", type="string", length=255, nullable=true)
     */
    protected $alt;

    /**
     * @var string
     *
     * @ORM\Column(name="file_name", type="string", length=255, nullable=false)
     * @Assert\File(mimeTypes={ "image/*" })
     */
    protected $fileName;

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * @param string $alt
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;
    }

    /**
     * @return string
     */
    public function getFilename()
    {
        return $this->fileName;
    }

    /**
     * @param string $filename
     */
    public function setFilename($filename)
    {
        if($this->getFilename() != $filename)
        {
            if(file_exists($this->getFilename()))
            {
                unlink($this->getFilename());
            }
        }

        $this->fileName = $filename;
    }

}

