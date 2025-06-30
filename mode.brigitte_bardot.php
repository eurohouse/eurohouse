<!-- head -->
<!-- CH: Brigitta Bardot; RU: Брижит Бардо; UA: Бріжит Бардо -->
<?php $degKoeff=(isset($settings['locale']['angle'][$units]['coefficient']))?$settings['locale']['angle'][$units]['coefficient']:$settings['locale']['angle']['default']['coefficient'];$degPreSign=(isset($settings['locale']['angle'][$units]['sign']['pre']))?$settings['locale']['angle'][$units]['sign']['pre']:$settings['locale']['angle']['default']['sign']['pre'];$degSign=(isset($settings['locale']['angle'][$units]['sign']['post']))?$settings['locale']['angle'][$units]['sign']['post']:$settings['locale']['angle']['default']['sign']['post']; ?>
<p align="center">
<?php if ($session['nsfw']==0) {
    if (horizontal($request['angle'],360)==0) { ?>
        <a href="<?=$portfolioPrefix.'left0.png';?>">
            <img style="width:6%;" src="<?=$portfolioPrefix.'left0.png';?>">
        </a>
        <a href="<?=$portfolioPrefix.'head.png';?>">
            <img style="width:11%;" src="<?=$portfolioPrefix.'head.png';?>">
        </a>
        <a href="<?=$portfolioPrefix.'right0.png';?>">
            <img style="width:6%;" src="<?=$portfolioPrefix.'right0.png';?>">
        </a>
    <?php } elseif (horizontal($request['angle'],360)==3) { ?>
        <a href="<?=$portfolioPrefix.'left270.png';?>">
            <img style="width:80%;" src="<?=$portfolioPrefix.'left270.png';?>">
        </a>
    <?php } elseif (horizontal($request['angle'],360)==1) { ?>
        <a href="<?=$portfolioPrefix.'right90.png';?>">
            <img style="width:80%;" src="<?=$portfolioPrefix.'right90.png';?>">
        </a>
    <?php } elseif (horizontal($request['angle'],360)==2) { ?>
        <a href="<?=$portfolioPrefix.'right180.png';?>">
            <img style="width:6%;" src="<?=$portfolioPrefix.'right180.png';?>">
        </a>
        <a href="<?=$portfolioPrefix.'left180.png';?>">
            <img style="width:6%;" src="<?=$portfolioPrefix.'left180.png';?>">
        </a>
    <?php }} ?>
</p>