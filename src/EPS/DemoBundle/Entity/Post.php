<?php

namespace EPS\DemoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * EPS\DemoBundle\Entity\Post
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="EPS\DemoBundle\Entity\PostRepository")
 */
class Post {

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Author", inversedBy="posts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="post")
     */
    private $comments;

    /**
     * @var string $title
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var date $datepost
     *
     * @ORM\Column(name="datepost", type="date")
     */
    private $datepost;

    public function __construct() {
        $this->comments = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     */
    public function setTitle($title) {
        $this->title = $title;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * Set author
     *
     * @param EPS\DemoBundle\Entity\Author $author
     */
    public function setAuthor(\EPS\DemoBundle\Entity\Author $author) {
        $this->author = $author;
    }

    /**
     * Get author
     *
     * @return EPS\DemoBundle\Entity\Author 
     */
    public function getAuthor() {
        return $this->author;
    }

    /**
     * Add comments
     *
     * @param EPS\DemoBundle\Entity\Comment $comments
     */
    public function addComment(\EPS\DemoBundle\Entity\Comment $comments) {
        $this->comments[] = $comments;
    }

    /**
     * Get comments
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getComments() {
        return $this->comments;
    }


    /**
     * Set datepost
     *
     * @param date $datepost
     */
    public function setDatepost($datepost)
    {
        $this->datepost = $datepost;
    }

    /**
     * Get datepost
     *
     * @return date 
     */
    public function getDatepost()
    {
        return $this->datepost;
    }
}