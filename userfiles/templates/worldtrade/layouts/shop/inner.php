<script type="text/javascript">

function set_gallery_img($new_src, $new_src_big){
	
//	$('.zoomWrapperImage img').attr('src', $new_src_big);
	//$('.zoomWrapperImage img').css('z-index',50000);
	//$('.zoomWrapperImage img').load();
	
	 // $(".hoverproduct").remove();
	
  $(".jqZoomWindow").remove();
  $(".jqZoomPup").remove();
  $(".jqzoom").remove();
  
  
  
  
  
  
 
 
  $('#set_gallery_img_z').append('<a href="'+$new_src_big+'" class="jqzoom"><img width="250" src="'+$new_src+'" id="main-product-image" /></a>');
 
  
  
  
  //$('#set_gallery_img').attr('src', $new_src);
	
	//$('#set_gallery_img_big').attr('href', $new_src_big);
  
  
  
  
  
  
  
  
  
  
  
  
  
  
 	make_jq_zoom()
}

function qty_to_price(){
	$q = $('#qty_for_price').val();
	
	$p = $('#products_option_form input[name="custom_field_price"]').val();
	 
	$end = $q * $p;
	
	
	$('#full_price_total').html($end);
	
	
	//alert($end );
	
}


function make_jq_zoom(){
	
   var options1 = {  
            zoomType: 'innerzoom',  
            lens:true,  
            preloadImages: false,  
            alwaysOn:false,  
            zoomWidth: 300,  
            zoomHeight: 250
            
            //...MORE OPTIONS  
    };  
    $('.jqzoom').jqzoom(options1);  	
}

$(document).ready(function() {
    qty_to_price()

//
//
//				            $('.jqzoom').jqzoom({
//															  lens:true,
//            preloadImages: false,
//					            					zoomType: 'innerzoom'
//					        					});
//				 
//					
					
					
			make_jq_zoom()	
 
});

 
</script>

<div class="left gallery_box">
  <microweber module="media/gallery" display="mics/gallery.php" content_id="<? print $post['id']; ?>">
  <?
 
/* 
  <div class="rounded_box transparent"> <img id="set_gallery_img" src="<? print get_media_thumbnail( $media ['pictures'][0]['id'] , 250)  ?>" width="250" alt="" />
    <div class="lt"></div>
    <div class="rt"></div>
    <div class="lb"></div>
    <div class="rb"></div>
  </div>
  <br/>
  <div id="gallery">
    <? if(!empty($media["pictures"])): ?>
    <? foreach($media["pictures"] as $pic): ?>
    <a href="javascript:set_gallery_img('<? print get_media_thumbnail( $pic['id'] , 250)  ?>');"><img src="<? print get_media_thumbnail( $pic['id'] , 70)  ?>" alt="" /></a>
    <? endforeach ;  ?>
    <? endif; ?>
    
    */
    ?>
  <!--  
  <a href="#"><img src="<? print TEMPLATE_URL ?>images/other/gallery/Products_inner_03.jpg" alt="" /></a> <a href="#"><img src="<? print TEMPLATE_URL ?>images/other/gallery/Products_inner_05.jpg" alt="" /></a> <a href="#"><img src="<? print TEMPLATE_URL ?>images/other/gallery/Products_inner_07.jpg" alt="" /></a> <a href="#"><img src="<? print TEMPLATE_URL ?>images/other/gallery/Products_inner_13.jpg" alt="" /></a> <a href="#"><img src="<? print TEMPLATE_URL ?>images/other/gallery/Products_inner_14.jpg" alt="" /></a> <a href="#"><img src="<? print TEMPLATE_URL ?>images/other/gallery/Products_inner_15.jpg" alt="" /></a>
  
  -->
</div>
<div class="left padding_L16 w350">
  <h1 class="title_product pink_color font_size_18"><? print $post['content_title']; ?></h1>
    

  <div class="products_description">
  <? print $post['content_description']; ?>
  <br />
<br />

  
   <? print $post['the_content_body']; ?> <br/>
    <!-- <span class="text_align_right pink_color"><i>Единична цена: <span class="font_size_18">38.00</span> лв.</i></span> -->
    <br />
     
       <div class="custom_field">  
       <a href="<? print TEMPLATE_URL ?>size_charts/tabl1.gif" class="pink_color" target="_blank">Таблица с размери</a>
      </div>

  </div>
  <br />
  <div class="product_added_holder">
    <h3>Успешно добавихте продукта в количката за пазаруване.</h3>
    <br />
    <br />
    <p> Имате <a href="<? print page_link($shop_page['id']); ?>/view:cart"><strong><span class="items cart_items_qty"><? print get_items_qty() ; ?></span> продукта</strong></a> във вашата кошница. </p>
    <div id="buy_it_box"> <a href="javascript:add_to_cart_callback();" class="rounded pink_color left"> <span class="in1"> <strong><span class="in2 min_w_120">Пазарувай още</span> </strong></span> </a> <a href="<? print page_link($shop_page['id']); ?>/view:cart" class="rounded right pink_btn"> <span class="in1"> <span class="in2 min_w_120">Завършете поръчката </span> </span> </a> </div>
  </div>
  <div class="product_info_holder">
  <table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div id="fb-root"></div><script src="http://connect.facebook.net/bg_BG/all.js#appId=156746347726744&amp;xfbml=1&amp;locale=bg_BG"></script><fb:like href="<? print post_link($post['id']);?>" locale="bg_BG" send="false" width="370" show_faces="true" action="recommend" font="arial"></fb:like></td>
  </tr>
</table>
    <p class="font_size_10"><i>* За да поръчате този продукт, трябва да изберете модел цвят и брой.</i></p>
    <form id="products_option_form" method="post" action="#">
      <input type="hidden" value="<? print $post['id'] ?>"   name="post_id" />
      <microweber module="content/custom_fields" content_id="<? print $post['id'] ?>" module_id="custom_fields_for_products<? print $page['id'] ?>" />
      <? 	//$cf_post =  CI::model ( 'core' )->getCustomFields('table_content', $post['id'], $return_full = true); 
	
	//p($cf_post);
	?>
      <!--<div class="left">
      <label>Избери Цвят:</label>
      <select>
        <option>цвят 1</option>
        <option>цвят 2</option>
      </select>
    </div>
    
    
    
    
    
    <div class="clener h10"></div>
    <div class="left">
      <label>Избери Размер:</label>
      <select>
        <option>цвят 1</option>
        <option>цвят 2</option>
      </select>
    </div>
    <div class="left">
      <label>Избери Брой:</label>
      <select>
        <option>цвят 1</option>
        <option>цвят 2</option>
      </select>
    </div>-->
      <? // p($cf_post); ?>
      <div class="left custom_field"> <span>Избери Брой:</span>
        <select name="qty" id="qty_for_price" onchange="qty_to_price()">
          <? for ($i = 1; $i <= 50; $i++) { ?>
          <option value="<?  print $i ?>">
          <?  print $i ?>
          </option>
          <? }  ?>
        </select>
      </div>
      
 
      
      
      
      <div class="clener"></div>
    </form>
    <div class="full_price">
      <table border="0" cellspacing="0" cellpadding="0" width="100%">
        <tr>
          <td align="center"><span class="pink_color font_size_18"><i>Крайна цена:</i></span></td>
          <td width="" align="center"><div id="full_price_total">
              <microweber module="content/custom_fields" content_id="<? print $post['id'] ?>" only_type="price" only_value="1"  module_id="custom_field_price_product<? print $page['id'] ?>" />
            </div></td>
          <td align="left"><div class="full_price_total"> <?php print option_get('shop_currency_sign') ; ?> </div></td>
        </tr>
      </table>
    </div> 


    
    
    
    
    
    
    
    <div id="buy_it_box"> <i>* Всички цени са в български лева</i> <a href="javascript:mw.cart.add('#products_option_form', function(){add_to_cart_callback()});" class="rounded right pink_btn"> <span class="in1"> <span class="in2 min_w_120">Купи сега</span> </span> </a> </div>
    
    
 
 
  
  </div>
</div>
<div class="clener"></div>
<div class="pattern_line margin_30-0-18-0"></div>
<h2 class="title_h40 pr"> Подобни продукти <span id="pager"></span> <span class="slide-btn_box" id="next"></span> <span class="slide-btn_box" id="prev"></span> </h2>
<div id="related_products">
  <? $cats =CATEGORY_IDS;

$cats = explode(',',$cats);

$last_cat = end($cats);
//p($last_cat);

?>
  <? if(!empty($cats )) : ?>
  <? $last_cat = end($cats);

$related_posts_params = array(); 
   //params for the output
   //$related_posts_params['display'] = 'post_item.php';
   //params for the posts
    $related_posts_params['selected_categories'] = array($last_cat); //if false will get the articles from the curent category. use 'all' to get all articles from evrywhere
  	$related_posts_params['items_per_page'] = 3; //limits the results by paging
	$related_posts_params['curent_page'] = 1; //curent result page
	//$related_posts_params['without_custom_fields'] = true; //if true it will get only basic posts info. Use this parameter for large queries
$related_posts = get_posts($related_posts_params);
$posts_data = $related_posts['posts'];
 include  TEMPLATE_DIR."layouts/shop/items_list.php"; 
 
 
 $related_posts_params = array(); 
   //params for the output
   //$related_posts_params['display'] = 'post_item.php';
   //params for the posts
    $related_posts_params['selected_categories'] = array($last_cat); //if false will get the articles from the curent category. use 'all' to get all articles from evrywhere
  	$related_posts_params['items_per_page'] = 3; //limits the results by paging
	$related_posts_params['curent_page'] = 2; //curent result page
	//$related_posts_params['without_custom_fields'] = true; //if true it will get only basic posts info. Use this parameter for large queries
$related_posts = get_posts($related_posts_params);
$posts_data = $related_posts['posts'];
 include  TEMPLATE_DIR."layouts/shop/items_list.php"; 
 
 
 
 $related_posts_params = array(); 
   //params for the output
   //$related_posts_params['display'] = 'post_item.php';
   //params for the posts
    $related_posts_params['selected_categories'] = array($last_cat); //if false will get the articles from the curent category. use 'all' to get all articles from evrywhere
  	$related_posts_params['items_per_page'] = 3; //limits the results by paging
	$related_posts_params['curent_page'] = 3; //curent result page
	//$related_posts_params['without_custom_fields'] = true; //if true it will get only basic posts info. Use this parameter for large queries
$related_posts = get_posts($related_posts_params);
$posts_data = $related_posts['posts'];
 include  TEMPLATE_DIR."layouts/shop/items_list.php"; 


//p($related_posts );
?>
  <? endif;  ?>
  <? 
 
 
 
 

 


 
   
 ?>
</div>