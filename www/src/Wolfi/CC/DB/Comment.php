<?php

namespace Wolfi\CC\DB;

class Comment
{
    /** @var int */
    private $commentId;

    /** @var int */
    private $postId;

    /** @var string */
    private $comment;

    /** @var string */
    private $timestamp;

    /** @var string */
    private $ip;

    /** @var string */
    private $useragent;

    /**
     * Comment constructor.
     * @param int $commentId
     * @param int $postId
     * @param string $comment
     * @param string $timestamp
     * @param string $ip
     * @param string $useragent
     */
    public function __construct($commentId, $postId, $comment, $timestamp, $ip, $useragent)
    {
        $this->commentId = $commentId;
        $this->postId = $postId;
        $this->comment = $comment;
        $this->timestamp = $timestamp;
        $this->ip = $ip;
        $this->useragent = $useragent;
    }

    /**
     * @return int
     */
    public function getCommentId()
    {
        return $this->commentId;
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
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @return string
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @return string
     */
    public function getUseragent()
    {
        return $this->useragent;
    }


}