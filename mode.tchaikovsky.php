<!-- head1 -->
<!-- CY: Τσαϊκόφσκι; GR: Τσαϊκόφσκι; RU: Чайковский; UA: Чайковський -->
<?php $degKoeff=(isset($settings['locale']['angle'][$units]['coefficient']))?$settings['locale']['angle'][$units]['coefficient']:$settings['locale']['angle']['default']['coefficient'];$degPreSign=(isset($settings['locale']['angle'][$units]['sign']['pre']))?$settings['locale']['angle'][$units]['sign']['pre']:$settings['locale']['angle']['default']['sign']['pre'];$degSign=(isset($settings['locale']['angle'][$units]['sign']['post']))?$settings['locale']['angle'][$units]['sign']['post']:$settings['locale']['angle']['default']['sign']['post']; ?>
<p align="center">
    <input type="number" min='0' max='270' step='90' id="setRotateAngle" style="width:26%;" placeholder="<?=term('Angle',$settings,$session);?>" value="<?=$request['angle'];?>" onkeydown="if (event.keyCode==27) {
        this.value='0';
    } else if (event.keyCode==8) { handleInput(this.value);
    } else if (event.keyCode==46) { handleInput(this.value);
    }" oninput="handleInput(this.value,true); omniRotate(parseInt(this.value));">
</p>
<p align="center">
    <a href="<?=$portfolioPrefix.'torso1.webp';?>">
        <img style="width:13%;" src="<?=$portfolioPrefix.'torso1.webp';?>">
    </a>
</p>
