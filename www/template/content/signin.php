<?php /** @var \League\Plates\Template\Template $this */ ?>
<?php $this->layout('layout', ['title' => $title]) ?>


<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <h2>Please Sign in</h2>
        <a class="btn btn-primary btn-lg" href="<?= $loginUrl ?>">Sign in with Facebook</a>
    </div>
</div>


