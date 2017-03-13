<?php

namespace Wolfi\CC\DB;

class Post
{
    /** @var int */
    private $postId;

    /** @var string */
    private $userId;

    /** @var string */
    private $fbId;

    /** @var string */
    private $message;

    /** @var string */
    private $created;

    /** @var string */
    private $publicUuid;

    /**
     * Post constructor.
     * @param int $postId
     * @param string $userId
     * @param string $fbId
     * @param string $message
     * @param string $created
     * @param string $publicUuid
     */
    public function __construct($postId, $userId, $fbId, $message, $created, $publicUuid)
    {
        $this->postId = $postId;
        $this->userId = $userId;
        $this->fbId = $fbId;
        $this->message = $message;
        $this->created = $created;
        $this->publicUuid = $publicUuid;
    }

    /**
     * @return int
     */
    public function getPostId()
    {
        return $this->postId;
    }

    /**
     * @return string
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getFbId()
    {
        return $this->fbId;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return string
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @return string
     */
    public function getPublicUuid()
    {
        return $this->publicUuid;
    }

}