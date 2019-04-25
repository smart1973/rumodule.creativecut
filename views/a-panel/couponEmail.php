<?php $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https://' : 'http://') . $_SERVER['SERVER_NAME']; ?>
<div style="width:600px;text-align:center;direction:rtl;font-family:Tahoma;line-height:1;background:url(<?php echo $url ?>/images/coupon-hor.png) center top / 580px 45px no-repeat, url(<?php echo $url ?>/images/coupon-hor.png) center bottom / 580px 45px no-repeat">
	<div style="padding:130px 0 200px;background:url(<?php echo $url ?>/images/coupon-ver.png) left 0 top 50px / 45px 310px no-repeat, url(<?php echo $url ?>/images/coupon-ver.png) left 0 bottom 50px / 45px 310px no-repeat,url(<?php echo $url ?>/images/coupon-ver.png) right 0 top 50px / 45px 310px no-repeat, url(<?php echo $url ?>/images/coupon-ver.png) right 0 bottom 50px / 45px 310px no-repeat">
		<img style="width:200px;margin-bottom:70px" src="<?php echo $url ?>/logo2.png">
		<h2 style="margin:20px 0;font-size:40px;font-weight:bold">קופון הנחה</h2>
		<div style="margin:10px 0;font-size:35px;font-weight:bold;color:#fe6c00"><?php echo $discount ?>%</div>
		<div style="margin-top:30px;font-size:25px;">קוד: <?php echo $coupon ?></div>
		<div style="margin-top:10px;font-size:25px;">שם: <?php echo $name ?></div>
	</div>
</div>