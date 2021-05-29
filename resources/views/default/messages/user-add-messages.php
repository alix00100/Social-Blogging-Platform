<?php include TEMPLATE_DIR . '/header.php'; ?>
<main class="w-100 max-width">
    <a class="right" href="/u/<?= $uid['login']; ?>/messages"><?= lang('All messages'); ?></a>
    <h1><?= $data['h1']; ?></h1>
    
    <form action="/messages/send" method="post">
    <?= csrf_field() ?>
        <input type="hidden" name="recipient" value="<?= $data['recipient_uid']; ?>" />
   
        <textarea rows="3" id="message" class="mess" placeholder="<?= lang('Write'); ?>..." type="text" name="message" /></textarea>
        <p>
            <input type="submit" name="submit" value="<?= lang('Send'); ?>" class="submit">    
        </p>
    </form>
</main>
<?php include TEMPLATE_DIR . '/footer.php'; ?>