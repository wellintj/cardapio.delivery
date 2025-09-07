<?php header("Content-type: text/css; charset: UTF-8"); ?>

<?php
if (isset($_GET['color'])) {
	$color = '#' . $_GET['color'];
	$hex_color = $_GET['color'];
}else{
	$color ='#50cd89';
	$hex_color ='50cd89';
}

?>

<?php if (isset($_GET['themes'])) {
	$themes = $_GET['themes'];
} ?>

<?php if (isset($_GET['theme_color'])) {
	$theme_color = $_GET['theme_color'];
} ?>

<?php
function hex2rgb($color)
{
	list($r, $g, $b) = array(
		$color[0] . $color[1],
		$color[2] . $color[3],
		$color[4] . $color[5]
	);
	$r = hexdec($r);
	$g = hexdec($g);
	$b = hexdec($b);
	return $r . ',' . $g . ',' . $b;
}
?>
.defaultColor{
	color: <?= $color ;?>!important;
}


.active.bgActive{
	background: <?= $color ;?>!important;
}
.bgActive{
	background: <?= $color ;?>!important;
	color:#fff;
}

.hoverbg:hover{
	background: <?= $color ;?>!important;
	color: #fff!important;
}
.hoverColor:hover{
	color: <?= $color ;?>!important;
}

.btn-primary{
	color: #fff;
	background-color: rgba(<?= hex2rgb($hex_color); ?>,.9)!important;
	border-color:  <?= $color ;?>!important;
}
.btn-primary:hover{
	opacity: .7;
}

.color-soft, .increaseDecrease a, span.value-button {
  color: rgba(<?= hex2rgb($hex_color); ?>,1)!important;
  background-color: rgba(<?= hex2rgb($hex_color); ?>,.1)!important;
}

.bg-color, .sidebarQty, .increaseDecrease a:hover, span.value-button:hover {
	background: rgba(<?= hex2rgb($hex_color); ?>,1)!important;
	color: #fff!important;
}

.softHover{
	background-color: rgba(<?= hex2rgb($hex_color); ?>,.1)!important;
	color: <?= $color ;?>!important;
	transition: all .3s ease-in-out;
}

.softHover:hover{
	background-color: rgba(<?= hex2rgb($hex_color); ?>,1)!important;
	color: #fff!important;
	transition: all .3s ease-in-out;
}

.softHover.active{
	background-color: rgba(<?= hex2rgb($hex_color); ?>,1)!important;
	color: #fff!important;
	transition: all .3s ease-in-out;
}

.default-border{
	border-color: rgba(<?= hex2rgb($hex_color); ?>,1)!important;
	
}
?>



.posArea ul.ci-pagination li.active a, 
.posArea ul.ci-pagination li.page-num:hover a, 
.posArea ul.ci-pagination li:first-child:hover a,
.posArea ul.ci-pagination li:last-child:hover a{
    color: #fff;
    background: <?= $color ;?>!important;
}
.posArea ul.ci-pagination li.active a,
.posArea ul.ci-pagination li.page-num:hover a,
.posArea ul.ci-pagination li:first-child:hover a,
.posArea ul.ci-pagination li:last-child:hover a{
	color: #fff;
    background: <?= $color ;?>!important;
}














<?php for ($i = 0; $i < 100; $i++) { ?>
	.pt-<?= $i; ?>{
	padding-top:<?= $i; ?>px!important;
	}

	.pb-<?= $i; ?>{
	padding-bottom:<?= $i; ?>px!important;
	}

	.pl-<?= $i; ?>{
	padding-left:<?= $i; ?>px!important;
	}

	.pr-<?= $i; ?>{
	padding-right:<?= $i; ?>px!important;
	}

	.mt-<?= $i; ?>{
	margin-top:<?= $i; ?>px!important;
	}

	.mb-<?= $i; ?>{
	margin-bottom:<?= $i; ?>px!important;
	}

	.ml-<?= $i; ?>{
	margin-left:<?= $i; ?>px!important;
	}

	.mr-<?= $i; ?>{
	margin-right:<?= $i; ?>px!important;
	}

	.p-<?= $i; ?>{
	padding:<?= $i; ?>px!important;
	}

	.m-<?= $i; ?>{
	margin:<?= $i; ?>px!important;
	}

	.fz-<?= $i; ?>{
	font-size:<?= $i; ?>px!important;
	}

	.ht-<?= $i; ?>{
	height:<?= $i; ?>px!important;
	}

	.wd-<?= $i; ?>{
	width:<?= $i; ?>px!important;
	}

	.min-w-<?= $i; ?>{
	min-width:<?= $i; ?>px!important;
	}

	.py-<?= $i; ?>{
	padding-top:<?= $i; ?>px!important;
	padding-bottom:<?= $i; ?>px!important;
	}

	.px-<?= $i; ?>{
	padding-left:<?= $i; ?>px!important;
	padding-right:<?= $i; ?>px!important;
	}

<?php } ?>