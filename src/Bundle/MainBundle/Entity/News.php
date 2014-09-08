<?php

namespace Bundle\MainBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * News
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Bundle\MainBundle\Repository\NewsRepository")
 */
class News
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(min=5, max=255)
     * @ORM\Column(name="text", type="string", length=255, nullable=false)
     */
    protected $text;

    /**
     * @ORM\ManyToMany(targetEntity="Bundle\MainBundle\Entity\Tag")
     **/
    protected $tags;

    /**
     * @ORM\ManyToOne(targetEntity="Bundle\MainBundle\Entity\User", fetch="EAGER")
     * @ORM\JoinColumn(nullable=false, name="authorId", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $author;

    protected $plainTags = array();

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set text
     *
     * @param string $text
     * @return News
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string 
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Add tags
     *
     * @param \Bundle\MainBundle\Entity\Tag $tags
     * @return News
     */
    public function addTag(\Bundle\MainBundle\Entity\Tag $tags)
    {
        $this->tags[] = $tags;

        return $this;
    }

    /**
     * Remove tags
     *
     * @param \Bundle\MainBundle\Entity\Tag $tags
     */
    public function removeTag(\Bundle\MainBundle\Entity\Tag $tags)
    {
        $this->tags->removeElement($tags);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTags()
    {
        return $this->tags;
    }
    
    /**
     * Set author
     *
     * @param \Bundle\MainBundle\Entity\User $author
     * @return News
     */
    public function setAuthor(\Bundle\MainBundle\Entity\User $author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \Bundle\MainBundle\Entity\User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    public function getPlainTags()
    {
        return $this->plainTags;
    }

    public function setPlainTags($plainTags)
    {
        $this->plainTags = $plainTags;
    }
    
    public function addPlainTags($plainTag)
    {
        $this->plainTags[] = $plainTag;
    }
}
