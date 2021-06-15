<?php include TEMPLATE_DIR . '/header.php'; ?>
<div class="wrap">
    <main class="w-75">
            <h1><?= $data['h1'] ?></h1>
            <?php if (!empty($data['messages'])) { ?>

                <?php foreach ($data['messages'] as  $msg) { ?>

                    <div class="msg-telo<?php if (!$msg['unread'] > 0) { ?> active<?php } ?>">
                        <?php if($msg['sender_uid'] == $uid['id']) {  ?>
                            <?= lang('You'); ?>  |  <?= $msg['update_time']; ?> <br>
                        <?php } else { ?>
                            <?= lang('From'); ?>
                             
                            <img src="<?= user_avatar_url($msg['msg_user']['avatar'], 'small'); ?>" class="msg-ava">
                             <a href="/u/<?= $msg['msg_user']['login']; ?>">
                                <?= $msg['msg_user']['login']; ?> 
                             </a>
                               <span class="date"> |  <?= $msg['update_time']; ?> </span>
                        <?php } ?>
                        
                        <div class="message one">
                            <?= $msg['message']['message']; ?>
                        </div>
                        
                        <a class="lowercase" href="/messages/read/<?= $msg['id']; ?>">
                            <?php if ($msg['unread']) { ?>
                                <?= lang('There are'); ?> <?= $msg['count']; ?> <?= $msg['unread_num']; ?>
                            <?php } else { ?>
                                <?= lang('View'); ?>  
                                <?php if($msg['count'] != 0) { ?> 
                                    <?= $msg['count']; ?>  <?= $msg['count_num']; ?>
                                <?php } ?>    
                            <?php } ?>
                        </a>
                        
                   </div>
                <?php } ?>
           
            <?php } else { ?>
                <div class="no-content"><?= lang('No dialogs'); ?>...</div>
            <?php } ?>
    </main>
</div>    
<?php include TEMPLATE_DIR . '/footer.php'; ?>