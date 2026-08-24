<!-- head0 -->
<!-- CH: Brigitta Bardot; RU: Брижит Бардо; SP: Brigitta Bardot; UA: Бріжит Бардо; VA: Brigitta Bardot -->
<?php $degKoeff=(isset($settings['locale']['angle'][$units]['coefficient']))?$settings['locale']['angle'][$units]['coefficient']:$settings['locale']['angle']['default']['coefficient'];$degPreSign=(isset($settings['locale']['angle'][$units]['sign']['pre']))?$settings['locale']['angle'][$units]['sign']['pre']:$settings['locale']['angle']['default']['sign']['pre'];$degSign=(isset($settings['locale']['angle'][$units]['sign']['post']))?$settings['locale']['angle'][$units]['sign']['post']:$settings['locale']['angle']['default']['sign']['post']; ?>
<p align="center">
    <input type="number" min='0' max='270' step='90' id="setRotateAngle" style="width:26%;" placeholder="<?=term('Angle',$settings,$session);?>" value="<?=$request['angle'];?>" onkeydown="if (event.keyCode==27) {
        this.value='0';
    } else if (event.keyCode==8) { handleInput(this.value);
    } else if (event.keyCode==46) { handleInput(this.value);
    }" oninput="handleInput(this.value,true); omniRotate(parseInt(this.value));">
</p>
<p align="center">
<?php if (circleDirection($request['angle'],360)==0) { ?>
    <a href="<?=$portfolioPrefix.'left0.webp';?>">
        <img style="width:7%;" src="<?=$portfolioPrefix.'left0.webp';?>">
    </a>
    <a href="<?=$portfolioPrefix.'torso0.webp';?>">
        <img style="width:13%;" src="<?=$portfolioPrefix.'torso0.webp';?>">
    </a>
    <a href="<?=$portfolioPrefix.'right0.webp';?>">
        <img style="width:7%;" src="<?=$portfolioPrefix.'right0.webp';?>">
    </a>
<?php } elseif (circleDirection($request['angle'],360)==3) { ?>
    <a href="<?=$portfolioPrefix.'right270.webp';?>">
        <img style="width:40%;" src="<?=$portfolioPrefix.'right270.webp';?>">
    </a><br>
    <a href="<?=$portfolioPrefix.'left270.webp';?>">
        <img style="width:40%;" src="<?=$portfolioPrefix.'left270.webp';?>">
    </a>
<?php } elseif (circleDirection($request['angle'],360)==1) { ?>
    <a href="<?=$portfolioPrefix.'left90.webp';?>">
        <img style="width:40%;" src="<?=$portfolioPrefix.'left90.webp';?>">
    </a><br>
    <a href="<?=$portfolioPrefix.'right90.webp';?>">
        <img style="width:40%;" src="<?=$portfolioPrefix.'right90.webp';?>">
    </a>
<?php } elseif (circleDirection($request['angle'],360)==2) { ?>
    <a href="<?=$portfolioPrefix.'right180.webp';?>">
        <img style="width:7%;" src="<?=$portfolioPrefix.'right180.webp';?>">
    </a>
    <a href="<?=$portfolioPrefix.'left180.webp';?>">
        <img style="width:7%;" src="<?=$portfolioPrefix.'left180.webp';?>">
    </a>
<?php } ?></p>
