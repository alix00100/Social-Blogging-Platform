<main class="w-100">
  <div class="bg-white items-center justify-between p15 mb15">

    <a href="/"><?= Translate::get('home'); ?></a> /
    <span class="red"><?= sprintf(Translate::get('add.option'), Translate::get('pages')); ?></span>
    
    <form action="<?= getUrlByName('content.create', ['type' => 'page']); ?>" method="post">
      <?= csrf_field() ?>

    <fieldset>
      <label for="post_title"><?= Translate::get('heading'); ?></label>
      <input minlength="6" maxlength="250" id="title" type="text" required="" name="post_title">
      <div class="help">6 - 250 <?= Translate::get('characters'); ?></div>  
    </fieldset>

      <?php if (!empty($data['blog'])) { ?>
        <?= Tpl::insert('/_block/form/select/blog', [
          'user'         => $user,
          'data'        => $data,
          'action'      => 'add',
          'type'        => 'blog',
          'title'       => Translate::get('blogs'),
        ]); ?>
      <?php } ?>

      <?php if (UserData::checkAdmin()) { ?>
        <?= Tpl::insert('/_block/form/select/section', [
          'user'           => $user,
          'data'          => $data['facets'],
          'type'          => 'section',
          'action'        => 'add',
          'title'         => Translate::get('section'),
          'help'          => Translate::get('necessarily'),
          'red'           => 'red'
        ]); ?>
      <?php } ?>

      <?= Tpl::insert('/_block/editor/editor', ['height'  => '250px', 'type' => 'page', 'id' => 0]); ?>

      <?= Html::sumbit(Translate::get('create')); ?>
    </form>
  </div>
</main>