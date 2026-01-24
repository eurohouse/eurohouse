<!-- head -->
<!-- CH: Brigitta Bardot; RU: Брижит Бардо; UA: Бріжит Бардо -->
<?php $degKoeff=(isset($settings['locale']['angle'][$units]['coefficient']))?$settings['locale']['angle'][$units]['coefficient']:$settings['locale']['angle']['default']['coefficient'];$degPreSign=(isset($settings['locale']['angle'][$units]['sign']['pre']))?$settings['locale']['angle'][$units]['sign']['pre']:$settings['locale']['angle']['default']['sign']['pre'];$degSign=(isset($settings['locale']['angle'][$units]['sign']['post']))?$settings['locale']['angle'][$units]['sign']['post']:$settings['locale']['angle']['default']['sign']['post']; ?>
<p align="center">
<?php if (horizontal($request['angle'],360)==0) { ?>
    <a href="<?=$portfolioPrefix.'left0.png';?>">
        <img style="width:7%;" src="<?=$portfolioPrefix.'left0.png';?>">
    </a>
    <a href="<?=$portfolioPrefix.'torso.png';?>">
        <img style="width:13%;" src="<?=$portfolioPrefix.'torso.png';?>">
    </a>
    <a href="<?=$portfolioPrefix.'right0.png';?>">
        <img style="width:7%;" src="<?=$portfolioPrefix.'right0.png';?>">
    </a>
<?php } elseif (horizontal($request['angle'],360)==3) { ?>
    <a href="<?=$portfolioPrefix.'right270.png';?>">
        <img style="width:40%;" src="<?=$portfolioPrefix.'right270.png';?>">
    </a><br>
    <a href="<?=$portfolioPrefix.'left270.png';?>">
        <img style="width:40%;" src="<?=$portfolioPrefix.'left270.png';?>">
    </a>
<?php } elseif (horizontal($request['angle'],360)==1) { ?>
    <a href="<?=$portfolioPrefix.'left90.png';?>">
        <img style="width:40%;" src="<?=$portfolioPrefix.'left90.png';?>">
    </a><br>
    <a href="<?=$portfolioPrefix.'right90.png';?>">
        <img style="width:40%;" src="<?=$portfolioPrefix.'right90.png';?>">
    </a>
<?php } elseif (horizontal($request['angle'],360)==2) { ?>
    <a href="<?=$portfolioPrefix.'right180.png';?>">
        <img style="width:7%;" src="<?=$portfolioPrefix.'right180.png';?>">
    </a>
    <a href="<?=$portfolioPrefix.'left180.png';?>">
        <img style="width:7%;" src="<?=$portfolioPrefix.'left180.png';?>">
    </a>
<?php } ?></p>
