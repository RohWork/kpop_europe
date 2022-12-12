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
            <p class="text-center" style="width:100%">hi! <b><?=$this->session->userdata('nick')?></b></p>
            <button class="btn btn-success text-center" style="width:100%" onclick="location.href='/member/logout'">LOGOUT</button>
            <?php } ?>
        </div>
        <a href="/" class="d-flex align-items-center pb-3 mb-3 link-dark text-decoration-none border-bottom">
            <svg class="bi me-2" width="30" height="24"><use xlink:href="#bootstrap"></use></svg>
            <span class="fs-5 fw-semibold">Kpop</span>
        </a>
        <ul class="list-unstyled ps-0">
            <li class="mb-1">
                <button class="btn btn-toggle align-items-center rounded" data-bs-toggle="collapse" data-bs-target="#party-collapse" aria-expanded="false">
                    Kpop Party
                </button>
                <div class="collapse" id="party-collapse">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">   
                        <li>
                            <a href="/main/calendar?country=1"><span class="btn-toggle-nav list-unstyled fw-normal pb-1 small link-dark">Schedule</span></a> 
                        </li>
                    </ul>
                </div>     
            </li>
            <li class="mb-1">
                <button class="btn btn-toggle align-items-center rounded" data-bs-toggle="collapse" data-bs-target="#concert-collapse" aria-expanded="false">
                    Kpop Concert
                </button>
                <div class="collapse" id="concert-collapse">
                    <ul class="btn-toggle-nav2 list-unstyled fw-normal pb-1 small">
                        <li>
                            <a href="/main/calendar?country=Czech"><span class="btn-toggle-nav list-unstyled fw-normal pb-1 small link-dark">Schedule</span></a>
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
            <li class="border-top my-3"></li>
            <li class="mb-1">
                <a href="#" class="btn btn-toggle align-items-center rounded">Community</a>
            </li>
            <?php if($this->session->userdata('level') > 1){ ?>
            <li class="border-top my-3"></li>
            <li class="mb-1">
                <a href="/main/schedule_insert" class="btn btn-toggle align-items-center rounded">Schedule Insert</a>
            </li>
            <?php }?>
            <?php if($this->session->userdata('level') > 2){ ?>
            <li class="border-top my-3"></li>
            <li class="mb-1">
                <a href="/main/country_insert" class="btn btn-toggle align-items-center rounded">Country Insert</a>
            </li>
            <li class="border-top my-3"></li>
            <li class="mb-1">
                <a href="/main/city_insert" class="btn btn-toggle align-items-center rounded">City Insert</a>
            </li>
            <li class="border-top my-3"></li>
            <li class="mb-1">
                <a href="/main/organization_insert" class="btn btn-toggle align-items-center rounded">Organizer Insert</a>
            </li>
            <?php }?>
        </ul>
    </div>
</div>
<div class="b-example-divider" id="side_bar_shadow"></div>
