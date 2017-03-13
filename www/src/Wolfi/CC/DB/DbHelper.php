<?php

namespace Wolfi\CC\DB;

use Ramsey\Uuid\Uuid;
use Wolfi\CC\Exception\NotFoundException;

class DbHelper
{
    /** @var  \PDO */
    private $db;

    /**
     * DbHelper constructor.
     * @param \PDO $db
     */
    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    /**
     * @param $fbPostId
     * @return false|int
     */
    public function postExists($fbPostId)
    {
        $sql = "SELECT postId FROM post WHERE fbId = :fbPostId";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['fbPostId' => $fbPostId]);
        if ($id = $stmt->fetch(\PDO::FETCH_COLUMN)) {
            return $id;
        }
        return false;
    }

    /**
     * @param int $userId
     * @param string $fbId
     * @param string $message
     * @param string $created
     * @return Post
     */
    public function savePost($userId, $fbId, $message, $created)
    {
        $sql = "INSERT INTO post
                (userId, fbId, message, created, publicUuid)
                VALUES
                (:userId, :fbId, :message, :created, :publicUuid)";
        $stmt = $this->db->prepare($sql);

        $publicUuid = Uuid::uuid4()->toString();
        $data = [
            'userId' => $userId,
            'fbId' => $fbId,
            'message' => $message,
            'created' => $created,
            'publicUuid' => $publicUuid,
        ];
        $stmt->execute($data);

        return new Post((int)$this->db->lastInsertId(), $userId, $fbId, $message, $created, $publicUuid);
    }

    /**
     * @param int $fbPostId
     * @return Post
     * @throws NotFoundException
     */
    public function getPostByFbPostId($fbPostId)
    {
        $sql = "SELECT * FROM post
                WHERE fbId = :fpPostId";
        $stmt = $this->db->prepare($sql);
        $data = [
            'fpPostId' => $fbPostId
        ];
        $stmt->execute($data);
        if ($stmt->rowCount() == 0) {
            throw new NotFoundException();
        }

        $res = $stmt->fetch(\PDO::FETCH_ASSOC);
        return new Post((int)$res['postId'], $res['userId'], $res['fbId'], $res['message'], $res['created'], $res['publicUuid']);
    }

    /**
     * @param int $userid
     * @return Post[]
     */
    public function getPostsByUserId($userid)
    {
        $sql = "SELECT * FROM post
                WHERE userId = :userId";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['userId' => $userid]);
        $res = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $res[] = new Post((int)$row['postId'], $row['userId'], $row['fbId'], $row['message'], $row['created'], $row['publicUuid']);
        }
        return $res;
    }

    public function getPostByPublicUuid($publicUuid)
    {
        $sql = "SELECT * FROM post
                WHERE publicUuid = :publicUuid";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['publicUuid' => $publicUuid]);
        if ($stmt->rowCount() == 0) {
            throw new NotFoundException();
        }

        $res = $stmt->fetch(\PDO::FETCH_ASSOC);
        return new Post((int)$res['postId'], $res['userId'], $res['fbId'], $res['message'], $res['created'], $res['publicUuid']);
    }

    /**
     * @param int $postId
     * @param string $comment
     * @return Comment
     */
    public function saveComment($postId, $comment, $ip, $useragent)
    {
        $sql = "INSERT INTO comment
                (postId, comment, ip, useragent)
                VALUES
                (:postId, :comment, :ip, :useragent)";
        $stmt = $this->db->prepare($sql);
        $data = [
            'postId' => $postId,
            'comment' => $comment,
            'ip' => $ip,
            'useragent' => $useragent,
        ];
        $stmt->execute($data);
    }

    public function getCommentsByPostId($postId)
    {
        $sql = "SELECT * FROM comment
                WHERE postId = :postId
                ORDER BY timestamp DESC
                ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['postId' => $postId]);

        $res = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $res[] = new Comment($row['commentId'], $row['postId'], $row['comment'], $row['timestamp'], $row['ip'], $row['useragent']);
        }

        return $res;
    }

}