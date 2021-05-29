<?php include TEMPLATE_DIR . '/header.php'; ?>
<main class="w-75">
    <h1><?= $data['h1']; ?></h1>
    
    <ul class="nav-tabs">
        <?php if($data['sheet'] == 'spaces') { ?>
            <li class="active">
                <span><?= lang('All'); ?></span>
            </li>
            <?php if($uid['id'] > 0) { ?>
                <li>
                    <a href="/space/my">
                        <span><?= lang('Signed'); ?></span>
                    </a>
                </li>
                <?php if($uid['trust_level'] >= Lori\Config::get(Lori\Config::PARAM_SPACE)) { ?>
                    <?php if($count_space <= 2) { ?>
                        <li class="right">
                            <a class="add-space" href="/space/add">
                                <span class="add">+</span> <?= lang('To create'); ?>
                            </a>
                        </li> 
                    <?php } ?> 
                <?php } ?> 
            <?php } ?>    
        <?php } else { ?>
            <li>
                <a href="/space">
                    <span><?= lang('All'); ?></span>
                </a>
            </li>
            <?php if($uid['id'] > 0) { ?>
                <li class="active">
                    <span><?= lang('Signed'); ?></span>
                </li>
                <?php if($uid['trust_level'] >= Lori\Config::get(Lori\Config::PARAM_SPACE)) { ?>
                    <?php if($count_space <= 2) { ?>
                        <li class="right">
                            <a class="add-space" href="/space/add">
                                <span class="add">+</span> <?= lang('To create'); ?>
                            </a>
                        </li> 
                    <?php } ?> 
                <?php } ?> 
            <?php } ?>
        <?php } ?>
    </ul>

    <?php if (!empty($space)) { ?>
  
        <?php foreach ($space as  $sp) { ?>  
            <div class="space-telo">
            
                <img class="space-img" alt="<?= $sp['space_name']; ?>" src="/uploads/spaces/logos/<?= $sp['space_img'] ?>">
                    <?php if($sp['space_user_id'] == $uid['id']) { ?>
                        <div class="my_space all"></div>
                    <?php } ?>
                <span class="space-name"> 
                    <a title="<?= $sp['space_name']; ?>" class="space-s" href="/s/<?= $sp['space_slug']; ?>">
                        <?= $sp['space_name']; ?>
                    </a> 
                </span> 
                <?php if($sp['space_type'] == 1) { ?>
                     <small><span class="red">— <?= lang('official'); ?></span></small> 
                <?php } ?>
                
                <?php if($sp['space_id'] != 1) { ?>
                    <sup>+ <?= $sp['users'] ?></sup>
                <?php } ?>

                <?php if(!$uid['id']) { ?> 
                    <div class="right"> 
                        <a href="/login"><div class="hide-space-id yes-space">+ <?= lang('Read'); ?></div></a>
                    </div>
                <?php } else { ?>
                    <?php if($sp['space_id'] !=1) { ?>
                        <?php if($sp['space_user_id'] != $uid['id']) { ?>
                            <div class="right"> 
                                <?php if($sp['signed_space_id'] >= 1) { ?>
                                    <div data-id="<?= $sp['space_id']; ?>" class="hide-space-id no-space">
                                        <?= lang('Unsubscribe'); ?>
                                    </div>
                                <?php } else { ?> 
                                    <div data-id="<?= $sp['space_id']; ?>" class="hide-space-id yes-space">
                                        + <?= lang('Read'); ?>
                                    </div>
                                <?php } ?>   
                            </div> 
                        <?php } ?>    
                    <?php } ?>                        
                <?php } ?> 

                <div class="space-des all">
                    <?php if($sp['space_description']) { ?> 
                        <?= $sp['space_description']; ?> 
                    <?php } else { ?> 
                        <?= lang('Description is formed'); ?>
                    <?php } ?>    
                </div>

            </div>
        <?php } ?>

    <?php } else { ?>
        <div class="no-answer"><i class="icon info"></i> <?= lang('No spaces'); ?></div>
    <?php } ?>

</main>
<aside>
    <?php if($data['sheet'] == 'spaces') { ?>
        <?= lang('info_space'); ?>
    <?php } else { ?>
        <?= lang('my_info_space'); ?>
    <?php } ?>
</aside>
<?php include TEMPLATE_DIR . '/footer.php'; ?>        