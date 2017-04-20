<?php include '_header.php'; ?>
<p>
    Here is an enquiry/message from <strong><?= ucfirst($first_name); ?> <?= ucfirst($last_name); ?> </strong>
    <br> Email : <strong><?= $email; ?></strong>
    <br> Phone : <strong><?= $phone; ?></strong>
</p>
<p>
    Message: <?= $message; ?>
</p>


<br/>

<?php include '_footer.php'; ?>