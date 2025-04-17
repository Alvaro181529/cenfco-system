<?php require 'template/head.php' ?>
<?php require 'template/navbar.php' ?>

<body>
    <div class="container mx-auto" style="width: 700px;">
        <div class="my-1">
            <h1 class="display-4 fw-bold mb-2"><?php echo $post['Title'] ?></h1>
            <?php
            $language = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
            if ($language == 'es') {
                setlocale(LC_TIME, 'es_ES.UTF-8');
            } else {
                setlocale(LC_TIME, 'en_US.UTF-8');
            }

            $datetime = new DateTime($post['Datetime']);

            $formattedDate = strftime('%A, %d de %B de %Y, %H:%M', $datetime->getTimestamp());
            ?>
            <h5 class="h6 mt-2 fw-semibold text-muted">
                Publicado el <?php echo $formattedDate; ?>
            </h5>
        </div>
        <hr class="my-4 border-top border-secondary">
        <div>
            <?php echo $post['Content'] ?>
        </div>
        <div class="container  position-fixed start-0 bottom-0 zindex-10">
            <a href="/dashboard/blog"><i class="bi bi-arrow-left-circle fs-1"></i></a>
        </div>
    </div>
    <?php require 'component/chat.php' ?>
    <?php require 'template/foot.php' ?>