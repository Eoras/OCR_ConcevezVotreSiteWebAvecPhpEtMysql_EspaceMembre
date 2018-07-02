<?php
if (!isset($_SESSION['auth']['isAuth']) OR !$_SESSION['auth']['isAuth']) {
    header('location: /');
    exit();
}
$messagesPerPage = $messagesPerPage <= 0 ? $messagesPerPage = 5 : $messagesPerPage;
$total = $dbManager->query('SELECT COUNT(*) AS total FROM message')->fetch()['total'];
$numberOfPages = ceil($total / $messagesPerPage);

if (isset($_GET['page'])) {
    $currentPage = intval($_GET['page']);
    if ($currentPage > $numberOfPages) {
        $currentPage = $numberOfPages;
        header("location: ?page=$numberOfPages");
        exit();
    }
} else {
    $currentPage = 1;
}

if ($total > 0) {
    $firstMessage = ($currentPage - 1) * $messagesPerPage;
    $messageToShow = $dbManager->query("
                          SELECT msg.message, DATE_FORMAT(msg.date, '%d/%m/%Y à %H:%i:%s') as date_format, mb.username
                          FROM message msg
                          INNER JOIN member mb
                          ON msg.member_id = mb.id
                          ORDER BY date DESC
                          LIMIT $firstMessage, $messagesPerPage");
}
?>
<div class="row">
    <div class="col-12">
        <h1>Mini Chat</h1>
        <div class="col-lg-6 mx-auto">
            <form action="action/addMessage.php" method="POST">
        <textarea name="message" id="message" cols="19" rows="5" placeholder="Your message"
                  class="form-control"></textarea>
                <p class="text-danger mb-2">
                    <small><i><?= $_SESSION['errors']['message'] ?? '' ?></i></small>
                </p>
                <button type="submit" class="btn btn-dark btn-sm float-right mb-3">Send</button>
                <div class="clearfix"></div>
            </form>
        </div>
        <?php
        if ($numberOfPages > 1) : ?>
            <div class="row">
                <div class="col-12">
                    <nav aria-label="Page navigation">
                        <ul class="pagination pagination-sm justify-content-center mt-2">
                            <?php
                            if ($numberOfPages > 1 AND $currentPage != 1) : ?>
                                <li class="page-item">
                                    <a href="index.php?page=<?= $currentPage - 1 ?>" aria-label="Next"
                                       class="page-link">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                            <?php else: ?>
                                <li class="disabled page-item">
                                    <span aria-hidden="true" class="page-link">&laquo;</span>
                                </li>
                            <?php endif;

                            for ($i = 1; $i <= $numberOfPages; $i++) {
                                if ($i == $currentPage) {
                                    echo '<li class="page-item active"><a href="#" class="page-link">' . $i . '</a></li>';
                                } else {
                                    echo '<li class="page-item"><a class="page-link" href="index.php?page=' . $i . '">' . $i . '</a></li>';
                                }
                            }
                            if ($numberOfPages > 1 AND $currentPage != $numberOfPages) : ?>
                                <li class="page-item">
                                    <a href="index.php?page=<?= $currentPage + 1 ?>" aria-label="Next"
                                       class="page-link">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            <?php else: ?>
                                <li class="page-item disabled">
                                    <span aria-hidden="true" class="page-link">&raquo;</span>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($total <= 0) echo "<p>Pas de messages</p>" ?>
        <?php
        if ($total > 0) :
            while ($message = $messageToShow->fetch()) :
                $parseMsg = stripslashes($message['message']); // We remove the slashes that would be automatically added
                $parseMsg = htmlspecialchars($parseMsg); // We make harmless HTML tags that the visitor could enter
                $parseMsg = nl2br($parseMsg); // We create <br /> to keep the line breaks

                // We pass our text through regex
                $parseMsg = preg_replace('#\[b\](.+)\[/b\]#isU', '<strong>$1</strong>', $parseMsg);
                $parseMsg = preg_replace('#\[i\](.+)\[/i\]#isU', '<em>$1</em>', $parseMsg);
                $parseMsg = preg_replace('#\[u\](.+)\[/u\]#isU', '<u>$1</u>', $parseMsg);
                $parseMsg = preg_replace('#\[color=(red|green|blue|yellow|purple|olive)\](.+)\[/color\]#isU', '<span style="color:$1">$2</span>', $parseMsg);
                $parseMsg = preg_replace('#(https?://[a-z0-9-._/-?&=][^<> \r\n]+)#i', '<a href="$1">$1</a>', $parseMsg);
                // $parseMsg = preg_replace('#\[img\](.+)\[/img\]#isU', '<img src="$1">', $parseMsg);
                $parseMsg = preg_replace('#[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}#', '<a href="mailto:$0">$0</a>', $parseMsg);

                ?>
                <div class="card mb-2">
                    <div class="card-body p-1">
                        <p class="card-text m-0">
                        <p class="m-0"><?= nl2br($parseMsg); ?></p>
                        <p class="m-0">
                            <small class="text-secondary">
                                <i>Envoyé le <?= $message['date_format']; ?> par
                                    <strong><?= htmlentities($message['username']); ?></strong>
                                </i>
                            </small>
                        </p>
                    </div>
                </div>
            <?php endwhile; endif; ?>
    </div>
</div>