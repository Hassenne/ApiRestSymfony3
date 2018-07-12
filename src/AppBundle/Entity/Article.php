<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use JMS\Serializer\Annotation as Serializer;


use JMS\Serializer\Annotation\ExclusionPolicy;

use JMS\Serializer\Annotation\Expose;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ArticleRepository")
 * @ORM\Table()
 *
 * @ExclusionPolicy("all")
 *
 */
class Article
{
    /**

     * @ORM\Column(type="integer")

     * @ORM\Id

     * @ORM\GeneratedValue(strategy="AUTO")

     *

     * @Expose

     */

    private $id;


    /**

     * @ORM\Column(type="string", length=100)

     * @Expose

     */

    private $title;


    /**

     * @ORM\Column(type="text")

     * @Expose

     */

    private $content;
    /**
     * @ORM\ManyToOne(targetEntity="Author", cascade={"all"}, fetch="EAGER")
     */
    private $author;

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function setAuthor(Author $author)
    {
        $this->author = $author;
    }
}