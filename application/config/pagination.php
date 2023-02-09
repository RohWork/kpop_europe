<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed'); 
 // application/config/pagination.php 
 
/*
 $config['pagination']['full_tag_open']      = '<ul class="pagination pagination-lg">'; 
 $config['pagination']['full_tag_close']    = '</ul>'; 
 $config['pagination']['first_tag_open']    = '<li>'; 
 $config['pagination']['first_tag_close']   = '</li>'; 
 $config['pagination']['last_tag_open']     = '<li>'; 
 $config['pagination']['last_tag_close']    = '</li>'; 
 $config['pagination']['next_tag_open']     = '<li><span>'; 
 $config['pagination']['next_tag_close']    = '</span></li>'; 
 $config['pagination']['prev_tag_open']     = '<li><span>'; 
 $config['pagination']['prev_tag_close']    = '</span></li>'; 
 $config['pagination']['cur_tag_open']      = '<li class="disabled"><span><b>'; 
 $config['pagination']['cur_tag_close']     = '</b></span></li>'; 
 $config['pagination']['num_tag_open']      = '<li><span>'; 
 $config['pagination']['num_tag_close']     = '</span></li>'; 
  
 $config['pagination']['uri_segment']       = 4;
 $config['pagination']['num_links']         = 5;
 * 
 */
 
//$config['first_link']   		= "&laquo;";
//$config['last_link']			= "&raquo;";


//$config['first_tag_open'] = '<li class="pageNum_btn"><div><p>';
//$config['first_tag_close'] = '</p></div></li>';

//$config['last_tag_open'] = '<li class="pageNum_btn"><div><p>';
//$config['last_tag_close'] = '</p></div></li>';


$config['prev_link']   		= '<img src="/images/icon/left_arrow.png"/>';
$config['next_link']		= '<img src="/images/icon/right_arrow.png"/>';

$config['prev_tag_open'] = '<li class="pageL_btn"><p>';
$config['prev_tag_close'] = '</p></li>';

$config['next_tag_open'] = '<li class="pageR_btn"><p>';
$config['next_tag_close'] = '</p></li>';

$config['cur_tag_open'] = '<li class="pageNum_btn"><div class="active"><p>';
$config['cur_tag_close'] = '</p></div></li>';

$config['num_tag_open'] = '<li class="pageNum_btn"><div><p>';
$config['num_tag_close'] = '</p></div></li>';

$config['base_url'] = current_url();
$config['per_page'] = 10;

$config['page_query_string'] = true;

$config['first_link'] = "";
$config['first_tag_open'] = "";
$config['first_tag_close'] = "";

$config['last_link'] = "";
$config['last_tag_open'] = "";
$config['last_tag_close'] = "";

//$config['use_page_numbers'] = TRUE;
//$config['reuse_query_string'] = TRUE;

$config['num_links'] = 2;

?> 