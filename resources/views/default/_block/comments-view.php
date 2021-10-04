<?php if (!empty($data['answers'])) { ?>
  <div class="bg-white br-rd-5 border-box-1 mt15 p15">
    <h2 class="lowercase m0 mb15 size-21">
      <?= $data['post']['post_answers_count'] + $data['post']['post_comments_count'] ?>
      <?= $data['post']['num_comments'] ?>
    </h2>
    <?php $n = 0;
    foreach ($data['answers'] as  $answer) {
      $n++;
      $post_url = getUrlByName('post', ['id' => $data['post']['post_id'], 'slug' => $data['post']['post_slug']]);
    ?>

      <div class="block-answer">
        <?php if ($answer['answer_is_deleted'] == 0) { ?>
          <?php if ($n != 1) { ?><div class="line mt10 mb10"></div><?php } ?>
          <ol class="p0 m0 list-none">
            <li class="answers_subtree" id="answer_<?= $answer['answer_id']; ?>">
              <div class="answ-telo">
                <div class="flex size-14">
                  <a class="gray-light" href="<?= getUrlByName('user', ['login' => $answer['user_login']]); ?>">
                    <?= user_avatar_img($answer['user_avatar'], 'small', $answer['user_login'], 'w18'); ?>
                    <span class="mr5 ml5">
                      <?= $answer['user_login']; ?>
                    </span>
                  </a>
                  <span class="mr5 ml5 gray-light lowercase">
                    <?= $answer['answer_date']; ?>
                  </span>
                  <?php if (empty($answer['edit'])) { ?>
                    <span class="mr5 ml10 gray-light">
                      (<?= lang('ed'); ?>.)
                    </span>
                  <?php } ?>
                  <?php if ($data['post']['post_user_id'] == $answer['answer_user_id']) { ?>
                    <span class="red mr5 ml0">&#x21af;</span>
                  <?php } ?>
                  <a rel="nofollow" class="gray-light mr5 ml10" href="<?= $post_url; ?>#answer_<?= $answer['answer_id']; ?>">#</a>
                  <?= includeTemplate('/_block/show-ip', ['ip' => $answer['answer_ip'], 'user_trust_level' => $uid['user_trust_level']]); ?>
                </div>
                <div class="mt0 mr0 mb5 ml0 size-15 max-w780">
                  <?= $answer['answer_content'] ?>
                </div>
              </div>
              <div class="flex size-14">
                <?= votes($uid['user_id'], $answer, 'answer'); ?>

                <?php if ($data['post']['post_closed'] == 0) { ?>
                  <?php if ($data['post']['post_is_deleted'] == 0 || $uid['user_trust_level'] == 5) { ?>
                    <a data-post_id="<?= $data['post']['post_id']; ?>" data-answer_id="<?= $answer['answer_id']; ?>" class="add-comment gray mr5 ml15"><?= lang('reply'); ?></a>
                  <?php } ?>
                <?php } ?>

                <?php if ($uid['user_id'] == $answer['answer_user_id'] || $uid['user_trust_level'] == 5) { ?>
                  <?php if ($answer['answer_after'] == 0 || $uid['user_trust_level'] == 5) { ?>
                    <a class="editansw gray mr10 ml10" href="/answer/edit/<?= $answer['answer_id']; ?>"> <?= lang('edit'); ?>
                    </a>
                  <?php } ?>
                <?php } ?>

                <?php if ($uid['user_trust_level'] == 5) { ?>
                  <a data-type="answer" data-id="<?= $answer['answer_id']; ?>" class="type-action gray ml10 mr5">
                    <i title="<?= lang('remove'); ?>" class="bi bi-trash"></i>
                  </a>
                <?php } ?>

                <?php if ($uid['user_id']) { ?>
                  <?php $blue = $answer['favorite_user_id'] ? 'blue' : 'gray'; ?>
                  <a id="fav-comm_<?= $answer['answer_id']; ?>" class="add-favorite mr5 ml15 gray <?= $blue; ?>" data-id="<?= $answer['answer_id']; ?>" data-type="answer">
                    <?php if ($answer['favorite_user_id']) { ?>
                      <i title="<?= lang('remove-favorites'); ?>" class="bi bi-bookmark"></i>
                    <?php } else { ?>
                      <i title="<?= lang('add-favorites'); ?>" class="bi bi-bookmark"></i>
                    <?php } ?>
                  </a>
                <?php } ?>

                <?php if ($uid['user_id'] != $answer['answer_user_id'] && $uid['user_trust_level'] > 0) { ?>
                  <a data-post_id="<?= $data['post']['post_id']; ?>" data-type="answer" data-content_id="<?= $answer['answer_id']; ?>" class="msg-flag gray ml15">
                    <i title="<?= lang('report'); ?>" class="bi bi-flag"></i>
                  </a>
                <?php } ?>
              </div>
              <div id="answer_addentry<?= $answer['answer_id']; ?>" class="reply"></div>
            </li>
          </ol>

        <?php } else { ?>

          <?php if ($uid['user_trust_level'] == 5) { ?>
            <ol class="bg-red-300 size-14 pr5 list-none">
              <li class="comments_subtree" id="comment_<?= $answer['answer_id']; ?>">
                <span class="comm-deletes nick">
                  <?= $answer['answer_content']; ?>
                  <?= lang('answer'); ?> — <?= $answer['user_login']; ?>
                  <a data-type="answer" data-id="<?= $answer['answer_id']; ?>" class="type-action right">
                    <span><?= lang('recover'); ?></span>
                  </a>
                </span>
              </li>
            </ol>
          <?php } else { ?>
            <div class="gray m5 p5 size-14">
              <span class="answ-deletes">~ <?= lang('comment deleted'); ?></span>
            </div>
          <?php } ?>

        <?php } ?>
      </div>

      <?php foreach ($answer['comm'] as  $comment) { ?>
        <?php if ($comment['comment_is_deleted'] == 0) { ?>
          <ol class="pl15 list-none<?php if ($comment['comment_comment_id'] > 0) { ?> ml30<?php } ?>">
            <li class="comment_subtree" id="comment_<?= $comment['comment_id']; ?>">
              <div class="p5">
                <div class="max-w780 size-15">
                  <div class="size-14 flex">
                    <a class="gray-light" href="<?= getUrlByName('user', ['login' => $comment['user_login']]); ?>">
                      <?= user_avatar_img($comment['user_avatar'], 'small', $comment['user_login'], 'w18'); ?>
                      <span class="mr5 ml5">
                        <?= $comment['user_login']; ?>
                      </span>
                    </a>
                    <span class="mr5 ml5 gray-light lowercase">
                      <?= lang_date($comment['comment_date']); ?>
                    </span>
                    <?php if ($data['post']['post_user_id'] == $comment['comment_user_id']) { ?>
                      <span class="red mr10 ml10">&#x21af;</span>
                    <?php } ?>
                    <?php if ($comment['comment_comment_id'] > 0) { ?>
                      <a class="gray-light mr10 ml10" rel="nofollow" href="<?= $post_url; ?>#comment_<?= $comment['comment_comment_id']; ?>">&uarr;</a>
                    <?php } else { ?>
                      <a class="gray-light mr10 ml10" rel="nofollow" href="<?= $post_url; ?>#answer_<?= $comment['comment_answer_id']; ?>">&uarr;</a>
                    <?php } ?>
                    <a class="gray-light mr5 ml10" rel="nofollow" href="<?= $post_url; ?>#comment_<?= $comment['comment_id']; ?>">#</a>
                    <?= includeTemplate('/_block/show-ip', ['ip' => $comment['comment_ip'], 'user_trust_level' => $uid['user_trust_level']]); ?>
                  </div>
                  <div class="comm-telo-body size-15 mt5 mb5">
                    <?= Agouti\Content::text($comment['comment_content'], 'line'); ?>
                  </div>
                </div>
                <div class="size-14 flex">
                  <?= votes($uid['user_id'], $comment, 'comment'); ?>

                  <?php if ($data['post']['post_closed'] == 0) { ?>
                    <?php if ($data['post']['post_is_deleted'] == 0 || $uid['user_trust_level'] == 5) { ?>
                      <a data-post_id="<?= $data['post']['post_id']; ?>" data-answer_id="<?= $answer['answer_id']; ?>" data-comment_id="<?= $comment['comment_id']; ?>" class="add-comment-re gray mr5 ml15">
                        <?= lang('reply'); ?>
                      </a>
                    <?php } ?>
                  <?php } ?>

                  <?php if (accessСheck($comment, 'comment', $uid, 1, 30) === true) { ?>
                    <a data-post_id="<?= $data['post']['post_id']; ?>" data-comment_id="<?= $comment['comment_id']; ?>" class="editcomm gray mr10 ml10">
                      <?= lang('edit'); ?>
                    </a>
                    <a data-type="comment" data-id="<?= $comment['comment_id']; ?>" class="type-action gray mr5 ml5">
                      <?= lang('remove'); ?>
                    </a>
                  <?php } ?>
                  <?php if ($uid['user_id'] != $comment['comment_user_id'] && $uid['user_trust_level'] > 0) { ?>
                    <a data-post_id="<?= $data['post']['post_id']; ?>" data-type="comment" data-content_id="<?= $comment['comment_id']; ?>" class="msg-flag gray ml15">
                      <i title="<?= lang('report'); ?>" class="bi bi-flag"></i>
                    </a>
                  <?php } ?>
                </div>
              </div>
              <div id="comment_addentry<?= $comment['comment_id']; ?>" class="reply"></div>
            </li>
          </ol>

        <?php } else { ?>
          <?php if (accessСheck($comment, 'comment', $uid, 1, 30) === true) { ?>
            <ol class="bg-red-300 size-14 list-none max-w780 size-15<?php if ($comment['comment_comment_id'] > 0) { ?> ml30<?php } ?>">
              <li class="pr5" id="comment_<?= $comment['comment_id']; ?>">
                <span class="comm-deletes gray">
                  <?= Agouti\Content::text($comment['comment_content'], 'line'); ?>
                  — <?= $comment['user_login']; ?>
                  <a data-type="comment" data-id="<?= $comment['comment_id']; ?>" class="type-action right size-14">
                    <?= lang('recover'); ?>
                  </a>
                </span>
              </li>
            </ol>
          <?php } ?>
        <?php } ?>
      <?php } ?>

    <?php } ?>
  </div>
<?php } else { ?>
  <?php if ($data['post']['post_closed'] != 1) { ?>
    <?= includeTemplate('/_block/no-content', ['lang' => 'there are no comments']); ?>
  <?php } ?>
<?php } ?>