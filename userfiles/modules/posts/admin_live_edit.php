<?
$is_shop = false;

if(isset($params['is_shop']) and $params['is_shop'] == 'y'){
	$is_shop = 1;
}

 ?>

<div class="mw_simple_tabs mw_tabs_layout_simple">
<ul class="mw_simple_tabs_nav">
  <li><a href="javascript:;" class="active">
    <? if($is_shop): ?>
    Products
    <? else:  ?>
    Posts
    <? endif;  ?>
    list</a></li>
  <li><a href="javascript:;">Skin/Template</a></li>
</ul>
<div class="tab">
  <? //$rand = uniqid(); ?>
  <? if($is_shop == false): ?>
  <? $pages = get_content('content_type=page&subtype=dynamic&is_shop=n&limit=1000');   ?>
  <? else:  ?>
  <? $pages = get_content('content_type=page&is_shop=y&limit=1000');   ?>
  <? endif; ?>
  <?php $posts_parent_page =  get_option('data-page-id', $params['id']); ?>
  <label class="mw-ui-label">Display posts from</label>
  <div class="mw-ui-select" style="width: 100%;">
    <select name="data-page-id" id="the_post_data-page-id{rand}"  class="mw_option_field"  >
      <option     <? if((0 == intval($posts_parent_page))): ?>   selected="selected"  <? endif; ?>>None</option>
      <?
$pt_opts = array();
$pt_opts['link'] = "{title}";
$pt_opts['list_tag'] = " ";
$pt_opts['list_item_tag'] = "option";
$pt_opts['active_ids'] = $posts_parent_page;
$pt_opts['remove_ids'] = $params['id'];
$pt_opts['active_code_tag'] = '   selected="selected"  ';
 if($is_shop != false){
	 $pt_opts['is_shop'] = 'y';
 }
 pages_tree($pt_opts);

  ?>
    </select>
  </div>
  <?php $show_fields =  get_option('data-show', $params['id']);
if(is_string($show_fields)){
$show_fields = explode(',',$show_fields);
 $show_fields = array_trim($show_fields);
}
if($show_fields == false or !is_array($show_fields)){
$show_fields = array();	
}


//d($show_fields);
 ?>
  <style type="text/css">

    .mw-ui-check input + span + span, body{
      font-size: 11px;
    }

    .fields-controlls li{
      list-style: none;
      clear: both;
      min-height: 45px;

      min-height: 32px;
      overflow: hidden;
      padding: 6px 6px 4px;
      border-radius:2px;

    }
    .fields-controlls li:hover{background: #F8F8F8}

    .mw-ui-label-horizontal{
      display: inline-block;
      float: left;
      text-align: right;
      padding-right: 10px;
      margin-top: 5px;
    }

    .mw-ui-check input + span{
      top: 5px;
    }

    </style>
  <div class="vSpace"></div>
  <label class="mw-ui-label">Display on posts: </label>
  <ul id="post_fields_sort_{rand}" class="fields-controlls">
    <li>
      <label class="mw-ui-check left">
        <input type="checkbox" name="data-show" value="thumbnail" class="mw_option_field" <? if(in_array('thumbnail',$show_fields)): ?>   checked="checked"  <? endif; ?> />
        <span></span> <span>Thumbnail</span> </label>
      <div class="right">
        <label class="mw-ui-label-horizontal">Size</label>
        <input name="data-thumbnail-size" class="mw_option_field"   type="text" style="width:65px;" placeholder="250x200"  value="<?php print get_option('data-thumbnail-size', $params['id']) ?>" />
      </div>
    </li>
    <li>
      <label class="mw-ui-check">
        <input type="checkbox" name="data-show" value="title" class="mw_option_field" <? if(in_array('title',$show_fields)): ?>   checked="checked"  <? endif; ?> />
        <span></span> <span>Title</span></label>
    </li>
    <li>
      <label class="mw-ui-check">
        <input type="checkbox" name="data-show" value="description" class="mw_option_field" <? if(in_array('description',$show_fields)): ?>   checked="checked"  <? endif; ?> />
        <span></span> <span>Description</span></label>
      <div class="right">
        <label class="mw-ui-label-horizontal">Length</label>
        <input name="data-character-limit" class="mw_option_field"   type="text" placeholder="80" style="width:65px;"  value="<?php print get_option('data-character-limit', $params['id']) ?>" />
      </div>
    </li>
    <? if($is_shop): ?>
    <li>
      <label class="mw-ui-check">
        <input type="checkbox" name="data-show" value="price" class="mw_option_field" <? if(in_array('price',$show_fields)): ?>   checked="checked"  <? endif; ?> />
        <span></span> <span>Show price</span></label>
    </li>
    <li>
      <label class="mw-ui-check">
        <input type="checkbox" name="data-show" value="add_to_cart" class="mw_option_field"  <? if(in_array('add_to_cart',$show_fields)): ?>   checked="checked"  <? endif; ?> />
        <span></span> <span>Add to cart</span></label>
      <div class="right">
        <label class="mw-ui-label-horizontal">Title</label>
        <input name="data-add-to-cart-text" class="mw_option_field" style="width:65px;" placeholder="Buy now"  type="text"    value="<?php print get_option('data-add-to-cart-text', $params['id']) ?>" />
      </div>
    </li>
    <? endif; ?>
    <li>
      <label class="mw-ui-check">
        <input type="checkbox" name="data-show" value="read_more" class="mw_option_field"  <? if(in_array('read_more',$show_fields)): ?>   checked="checked"  <? endif; ?> />
        <span></span> <span>Read More Link</span></label>
      <div class="right">
        <label class="mw-ui-label-horizontal">Title</label>
        <input name="data-read-more-text" class="mw_option_field"   type="text" placeholder="Read more" style="width:65px;"   value="<?php print get_option('data-read-more-text', $params['id']) ?>" />
      </div>
    </li>
    <li>
      <label class="mw-ui-check">
        <input type="checkbox" name="data-show" value="created_on" class="mw_option_field"  <? if(in_array('created_on',$show_fields)): ?>   checked="checked"  <? endif; ?> />
        <span></span> <span>Date</span></label>
    </li>
    <li>
      <label class="mw-ui-check left">
        <input type="checkbox" name="data-hide-paging" value="y" class="mw_option_field" <? if(get_option('data-hide-paging', $params['id']) =='y'): ?>   checked="checked"  <? endif; ?> />
        <span></span><span>Hide paging</span></label>
      <div class="right">
        <label class="mw-ui-labe-horizontall">Posts per page</label>
        <input name="data-limit" class="mw_option_field"   type="number"  style="width:65px;" placeholder="10"  value="<?php print get_option('data-limit', $params['id']) ?>" />
      </div>
    </li>
  </ul>
</div>
<div class="tab">
  <module type="admin/modules/templates" id="posts_list_templ" />
</div>
<div class="mw_clear"></div>
<div class="vSpace"></div>