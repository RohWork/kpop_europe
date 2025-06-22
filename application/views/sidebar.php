<?php
    $lang = $this->session->userdata('lang');
    
    if(empty($lang)){
        $lang = "en"; 
    }
    
    $this->lang->load('menu', $lang);
    
    $url = $_SERVER[ "REQUEST_URI" ];
    $url_split = explode("/", $url);
    $url_show = array("country", "city", "organization","space");
    $url_show2 = array("insert", "excel");
    
    $col_show = "";
    if(in_array($url_split[1],$url_show)){
        $col_show = "show";
    }else if($url_split[1] == "schedule" && in_array($url_split[2],$url_show2)){
        $col_show = "show";
    }
?>


<main>
<link href="/asset/css/sidebar.css" rel="stylesheet">
<style>
    @media(max-width:767px){
        #side_bar{
            display: none;
        }
        #side_bar_shadow{
            display: none;
        }
    }
</style>
<div id="side_bar">
    <div class="flex-shrink-0 p-3 bg-white" style="width:200px">

        <div class="mb-4 pb-4" >
            <?php if(empty($this->session->userdata('name') )){ ?>
            <button class="btn btn-success text-center" style="width:100%" onclick="location.href='/member/login'">LOGIN</button>
            <?php }else{ ?>
            <p class="text-center" style="width:100%;cursor: pointer" onclick="location.href='/member/my_info'">hi! <b><?=$this->session->userdata('nick')?></b></p>
            <button class="btn btn-success text-center" style="width:100%" onclick="location.href='/member/logout'">LOGOUT</button>
            <?php } ?>
        </div>
        <ul class="list-unstyled ps-0">
            <!--<li class="mb-1">
                <button class="btn btn-toggle align-items-center rounded" data-bs-toggle="collapse" data-bs-target="#party-collapse" aria-expanded="false">
                    Kpop Schedule
                </button>
                <div class="collapse" id="party-collapse">
                    <ul class="btn-toggle-nav2 list-unstyled fw-normal pb-1 small">   
                        <li>
                            <a href="/schedule/calendar?country=1"><span class="btn-toggle-nav list-unstyled fw-normal pb-1 small link-dark"><?=$this->lang->line('calendar')?></span></a> 
                        </li>
                        <li>
                             <a href="/schedule/list"><span class="btn-toggle-nav list-unstyled fw-normal pb-1 small link-dark"><?=$this->lang->line('list')?></span></a>
                        </li>
                    </ul>
                </div>     
            </li>
            -->
            <?php if(!empty($this->session->userdata('name') )){ ?>
            <li class="mb-1">
                <a href="/member/my_info" class="btn btn-toggle align-items-center rounded"><?=$this->lang->line('my_kpop')?></a>
            </li>
            <?php } ?>

            <li class="border-top my-3"></li>
            
            <li class="mb-1">
                <a href="/schedule/list" class="btn btn-toggle align-items-center rounded"><?=$this->lang->line('kpop_schedule')?></a>
            </li>
            <!--
            <li class="border-top my-3"></li>

            <li class="mb-1">
                <a href="/schedule/list" class="btn btn-toggle align-items-center rounded"><?=$this->lang->line('kpop_list')?></a>
            </li>
            
            <!--
            <li class="mb-1">
                <button class="btn btn-toggle align-items-center rounded" data-bs-toggle="collapse" data-bs-target="#concert-collapse" aria-expanded="false">
                    Kpop Concert
                </button>
                <div class="collapse" id="concert-collapse">
                    <ul class="btn-toggle-nav2 list-unstyled fw-normal pb-1 small">
                        <li>
                            <a href="/schedule/calendar?country=1"><span class="btn-toggle-nav list-unstyled fw-normal pb-1 small link-dark">Schedule</span></a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="mb-1">
                <button class="btn btn-toggle align-items-center rounded" data-bs-toggle="collapse" data-bs-target="#club-collapse" aria-expanded="false">
                    Kpop Club
                </button>
                <div class="collapse" id="club-collapse">
                    <ul class="btn-toggle-nav2 list-unstyled fw-normal pb-1 small">
                        <li><a href="#"><span class="btn-toggle-nav2 list-unstyled pb-1 small link-dark">Contact us</span></a></li>
                    </ul>
                </div>
            </li>
            -->
            <li class="border-top my-3"></li>
            <li class="mb-1">
                <a href="/community/list?community_type=1" class="btn btn-toggle align-items-center rounded"><?=$this->lang->line('community')?></a>
            </li>
            <li class="border-top my-3"></li>
            <li class="mb-1">
                <a href="/community/list?community_type=2" class="btn btn-toggle align-items-center rounded"><?=$this->lang->line('getparty')?></a>
            </li>
            <!--<li class="border-top my-3"></li>
            <li class="mb-1">
                <button class="btn btn-toggle align-items-center rounded" data-bs-toggle="collapse" data-bs-target="#input-collapse" aria-expanded="false">
                    <?=$this->lang->line('schedule')?>
                </button>
                
                <div class="collapse" id="input-collapse">
                    <ul class="btn-toggle-nav2 list-unstyled fw-normal pb-1 small">
                        <li>
                             <a href="/schedule/list"><span class="btn-toggle-nav list-unstyled fw-normal pb-1 small link-dark"><?=$this->lang->line('list')?></span></a>
                        </li>
                    </ul>
                </div>
            </li>-->
            
            <?php if($this->session->userdata('level') > 2){ ?>
            <li class="border-top my-3"></li>
            <li class="mb-1">
                <button class="btn btn-toggle align-items-center rounded" data-bs-toggle="collapse" data-bs-target="#management-collapse" aria-expanded="true">
                    <?=$this->lang->line('Management')?>
                </button>
                <div class="collapse <?=$col_show?>" id="management-collapse">
                    <ul class="btn-toggle-nav2 list-unstyled fw-normal pb-1 small">
                        <li>
                            
                            <a href="/country"><span class="btn-toggle-nav list-unstyled fw-normal pb-1 small link-dark"><?=$this->lang->line('Country')?></span></a>
                            <a href="/city"><span class="btn-toggle-nav list-unstyled fw-normal pb-1 small link-dark"><?=$this->lang->line('City')?></span></a>
                            <a href="/organization"><span class="btn-toggle-nav list-unstyled fw-normal pb-1 small link-dark"><?=$this->lang->line('Organizer')?></span></a>
                            <a href="/space"><span class="btn-toggle-nav list-unstyled fw-normal pb-1 small link-dark"><?=$this->lang->line('Club')?></span></a>
                        </li>
                        <?php if($this->session->userdata('level') > 1){ ?>
                        <li>
                            <a href="/schedule/insert"><span class="btn-toggle-nav list-unstyled fw-normal pb-1 small link-dark"><?=$this->lang->line('data_insert')?></span></a>
                        </li>
                        <?php }?>
                        <li>
                            <a href="/schedule/excel"><span class="btn-toggle-nav list-unstyled fw-normal pb-1 small link-dark"><?=$this->lang->line('excel_upload')?></span></a>
                        </li>                  
                    </ul>
                </div>
                
            </li>
            <?php }?>
        </ul>
    </div>
</div>
<div class="b-example-divider" id="side_bar_shadow"></div>
