<?php

namespace EPS\DemoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EPS\DemoBundle\Entity\Comment
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="EPS\DemoBundle\Entity\CommentRepository")
 */
class Comment {

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Post", inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $post;

    /**
     * @var date $datecomment
     *
     * @ORM\Column(name="datecomment", type="date")
     */
    private $datecomment;

    /**
     * @var string $content
     *
     * @ORM\Column(name="content", type="string", length=255)
     */
    private $content;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set datecomment
     *
     * @param date $datecomment
     */
    public function setDatecomment($datecomment) {
        $this->datecomment = $datecomment;
    }

    /**
     * Get datecomment
     *
     * @return date 
     */
    public function getDatecomment() {
        return $this->datecomment;
    }

    /**
     * Set content
     *
     * @param string $content
     */
    public function setContent($content) {
        $this->content = $content;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent() {
        return $this->content;
    }


    /**
     * Set post
     *
     * @param EPS\DemoBundle\Entity\Post $post
     */
    public function setPost(\EPS\DemoBundle\Entity\Post $post)
    {
        $this->post = $post;
    }

    /**
     * Get post
     *
     * @return EPS\DemoBundle\Entity\Post 
     */
    public function getPost()
    {
        return $this->post;
    }
}