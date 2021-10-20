<div class="sticky col-span-2 justify-between no-mob">
  <?= includeTemplate('/_block/menu', ['sheet' => $data['sheet'], 'uid' => $uid]); ?>
</div>
<main class="col-span-7 mb-col-12">
  <div class="bg-white br-rd5 border-box-1 pt5 pr15 pb5 pl15">
    <h1><?= lang($data['sheet']); ?></h1>
    <form class="form max-w300" action="<?= getUrlByName('recover'); ?>/send" method="post">
      <?php csrf_field(); ?>

      <?= includeTemplate('/_block/form/field-input', ['data' => [
        ['title' => lang('E-mail'), 'type' => 'email', 'name' => 'email', 'value' => ''],
      ]]); ?>

      <?= includeTemplate('/_block/captcha'); ?>

      <div class="mb20">
        <button type="submit" class="button br-rd5 white">
          <?= lang('reset'); ?>
        </button>
        <?php if (Config::get('general.invite')) { ?>
          <span class="mr5 ml15 size-14"><a href="<?= getUrlByName('register'); ?>"><?= lang('sign up'); ?></a></span>
        <?php } ?>
        <span class="mr5 ml15 size-14"><a href="<?= getUrlByName('login'); ?>"><?= lang('sign in'); ?></a></span>
      </div>
    </form>
</main>
<?= includeTemplate('/_block/aside-lang', ['lang' => lang('info-recover')]); ?>