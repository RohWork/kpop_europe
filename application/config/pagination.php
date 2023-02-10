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

$config['attributes'] = array('class' => 'page-link');

$config['full_tag_open'] = '<ul class="pagination navigation justify-content-center">';
$config['full_tag_close'] = '</ul>';


$config['prev_link']   		= '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-double-left" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M8.354 1.646a.5.5 0 0 1 0 .708L2.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
  <path fill-rule="evenodd" d="M12.354 1.646a.5.5 0 0 1 0 .708L6.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
</svg>';
$config['next_link']		= '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-double-right" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M3.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L9.293 8 3.646 2.354a.5.5 0 0 1 0-.708z"/>
  <path fill-rule="evenodd" d="M7.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L13.293 8 7.646 2.354a.5.5 0 0 1 0-.708z"/>
</svg>';

$config['prev_tag_open'] = '<li class="page-item"> ';
$config['prev_tag_close'] = '</li>';

$config['next_tag_open'] = '<li class="page-item"> ';
$config['next_tag_close'] = '</li>';

$config['cur_tag_open'] = '<li class="page-item active" aria-current="page"> <a class="page-link" href="#">';
$config['cur_tag_close'] = '</a></li>';

$config['num_tag_open'] = '<li class="page-item">';
$config['num_tag_close'] = '</li>';

$config['base_url'] = current_url();
$config['per_page'] = 10;

//$config['page_query_string'] = true;

$config['first_link'] = false;
$config['first_tag_open'] = '';
$config['first_tag_close'] = '';

$config['last_link'] = false;
$config['last_tag_open'] = '';
$config['last_tag_close'] = '';

//$config['use_page_numbers'] = TRUE;
//$config['reuse_query_string'] = TRUE;

$config['num_links'] = 2;

?> 