<?php /** @var \League\Plates\Template\Template $this */ ?>
<?php $this->layout('layout', ['title' => $title]) ?>

<div class="row margin-top-50">
    <div class="col-md-12">
        <a href="/" class="btn btn-default">Back Home</a>
    </div>
</div>

<div class="row margin-top-50">
    <div class="col-md-12">
        <h1>Your Posts</h1>

        <?php if (count($posts)): ?>
            <?php /** @var \Wolfi\CC\DB\Post $post */ ?>
            <?php foreach ($posts as $post): ?>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <strong><?= $post->getCreated() ?></strong>
                        <br>
                        Public Link <a href="http://127.0.0.1:8080/public/<?= $post->getPublicUuid() ?>">http://127.0.0.1:8080/public/<?= $post->getPublicUuid() ?></a>
                        <br>
                        <?= $this->e($post->getMessage()) ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="alert alert-danger" role="alert">
                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                <strong>Sorry:</strong> Your List is empty.
            </div>
        <?php endif; ?>

    </div>
</div>
