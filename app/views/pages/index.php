<?php require APPROOT . '/views/inc/header.php' ?>
<div class="jumbotron jumbotron-fluid h-100">
    <div class="container-md text-center bg-dark-subtle mb-3 mt-3 h-25 w-75">
        <h1 class="display-3">
            <?php echo $data['title']; ?>
        </h1>
        <p class="lead">
            <?php echo $data['description']; ?>
        </p>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php' ?>