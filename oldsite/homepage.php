<?php
/*
Template Name: Home Page
*/
?>

<?php get_header(); ?>

	<div id="content-home">

			<div id="code">
<table border="0" width="100%" align="left">
<!-- tr>
  <td><img src="/wp-content/themes/book/images/buyNowBig.jpg" width=100 height=100 alt="Buy Now"/>
  </td>
</tr-->
<tr>
<td width="55%">&nbsp;</td>

<td width="45%">
<div class="bubbleInfo">
  <div>
    <img class="trigger" border="0" 
      src="/wp-content/themes/book/images/buyNowSmall.gif" />
  </div>
  <table id="dpop" class="popup"><tbody>
    <tr>
      <td id="topleft" class="corner"></td>
      <td class="top"></td>
      <td id="topright" class="corner"></td>
    </tr>

    <tr>
      <td class="left"></td>
      <td><table class="popup-contents"><tbody>
        <tr>
          <td>
<a href="http://click.linksynergy.com/fs-bin/click?id=*vcxpRjl3e8&offerid=163217.1221761&type=2&subid=0" >informIT Print</a><IMG border=0 width=1 height=1 src="http://ad.linksynergy.com/fs-bin/show?id=*vcxpRjl3e8&bids=163217.1221761&type=2&subid=0" >
          </td>
        </tr>
        <tr>
          <td>
<a href="http://click.linksynergy.com/fs-bin/click?id=*vcxpRjl3e8&offerid=163217.1235980&type=2&subid=0">informIT eBook</a><IMG border=0 width=1 height=1 src="http://ad.linksynergy.com/fs-bin/show?id=*vcxpRjl3e8&bids=163217.1235980&type=2&subid=0" >
          </td>
        </tr>
        <tr>
          <td>
<a href="http://www.amazon.com/gp/product/0321585712?ie=UTF8&tag=equinoxosgior-20&linkCode=as2&camp=1789&creative=9325&creativeASIN=0321585712">Amazon</a><img src="http://www.assoc-amazon.com/e/ir?t=equinoxosgior-20&l=as2&o=1&a=0321585712" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />
          </td>
        </tr>
        <tr>
          <td>
<a href="http://safari.informit.com/0321561511?cid=ptg-productwidget">Safari Online</a>
          </td>
        </tr>
        <tr>
          <td>
<a href="http://ebookpie.com/109-8-3-6.html" target="_blank">eBookPie</a>
          </td>
        </tr>
      </tbody></table>
    </td>
    <td class="right"></td>    
  </tr>
  <tr>
    <td class="corner" id="bottomleft"></td>
    <td class="bottom"></td>
    <td id="bottomright" class="corner"></td>
  </tr>
</tbody></table>
</div>
</tr>
</table>
</div>

		<table width="100%" cellspacing="5" cellpadding="5">
			<tbody>
			<tr>
				<td valign="top" width="50%">

					<div class="section">
						<h2 class="heading">What's New</h2>
					</div>
 
		 			<?php query_posts('category_name=news&showposts=4'); ?>
	
	  				<?php while (have_posts()) : the_post(); ?>

					<div class="item">
						<a href="<?php the_permalink(); ?>">
						<?php the_title(); ?>	
						</a>
					</div>

					<div class="item">
	  					<?php the_excerpt(); ?>
					</div>

  					<?php endwhile;?>

				</td>

				<td valign="top" width="50%">	

					<div class="section">
						<h2 class="heading">Spotlights</h2>
					</div>
 
		 			<?php query_posts('category_name=spotlight&showposts=4'); ?>
	
		  			<?php while (have_posts()) : the_post(); ?>
	
					<div class="item">
						<a href="<?php the_permalink(); ?>">
						<?php the_title(); ?>	
						</a>
					</div>

					<div class="item">
	  					<?php the_excerpt(); ?>
					</div>

  					<?php endwhile;?>

				</td>
			</tr>
			</tbody>
	</div>

    <script type="text/javascript">
    <!--

    $(function () {
        $('.bubbleInfo').each(function () {
            var distance = 10;
            var time = 250;
            var hideDelay = 500;
            var hideDelayTimer = null;
            var beingShown = false;
            var shown = false;
            var trigger = $('.trigger', this);
            var info = $('.popup', this).css('opacity', 0);

            $([trigger.get(0), info.get(0)]).mouseover(function () {
                if (hideDelayTimer) clearTimeout(hideDelayTimer);
                if (beingShown || shown) {
                    // don't trigger the animation again
                    return;
                } else {
                    // reset position of info box
                    beingShown = true;

                    info.css({
                        top: 50,
                        left: 50,
                        display: 'block'
                    }).animate({
                        top: '-=' + distance + 'px',
                        opacity: 1
                    }, time, 'swing', function() {
                        beingShown = false;
                        shown = true;
                    });
                }

                return false;
            }).mouseout(function () {
                if (hideDelayTimer) clearTimeout(hideDelayTimer);
                hideDelayTimer = setTimeout(function () {
                    hideDelayTimer = null;
                    info.animate({
                        top: '-=' + distance + 'px',
                        opacity: 0
                    }, time, 'swing', function () {
                        shown = false;
                        info.css('display', 'none');
                    });

                }, hideDelay);

                return false;
            });
        });
    });
    
    //-->
    </script>

<?php get_footer(); ?>
