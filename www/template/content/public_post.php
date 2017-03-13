<?php /** @var \League\Plates\Template\Template $this */ ?>
<?php /** @var \Wolfi\CC\DB\Post $post */ ?>
<?php $this->layout('layout', ['title' => $title]) ?>

<div class="slide">

    <div class="row row margin-top-50">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">Your last Post</div>
                <div class="panel-body">
                    <strong><?= $post->getCreated() ?></strong>
                    <br>
                    Public Link <a href="http://127.0.0.1:8080/public/<?= $post->getPublicUuid() ?>">http://127.0.0.1:8080/public/<?= $post->getPublicUuid() ?></a>
                    <br>
                    <?= $this->e($post->getMessage()) ?>
                </div>
            </div>

            <button class="btn btn-primary" id="leaveComment">Leave a Comment</button>
        </div>
    </div>

    <?php if (count($comments)): ?>
    <div class="row margin-top-50">
        <div class="col-md-12">
            <?php /** @var \Wolfi\CC\DB\Comment $comment */ ?>
            <?php foreach ($comments as $comment): ?>
                <ul>
                    <li><?= $this->e($comment->getComment()) ?></li>
                </ul>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <div class="row margin-top-50 display-none" id="commentBox">
        <div class="col-md-12">
            <h4>Leave a Comment</h4>
            <form method="post" action="/post/<?= $post->getFbId() ?>">
                <div class="form-group">
                    <input name="inputComment" type="text" class="form-control" id="inputComment" placeholder="Leave a comment" required>
                </div>
                <input type="submit" class="btn btn-default" value="Save">
            </form>
        </div>
    </div>


</div>

<script src="/bower_components/jquery/dist/jquery.min.js"></script>
<script src="/js/post.js"></script>
