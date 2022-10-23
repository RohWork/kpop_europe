<main>
<link href="/asset/css/sidebar.css" rel="stylesheet">
<div class="flex-shrink-0 p-3 bg-white" style="width:200px">
    
    <div class="mb-1 border-bottom">
        <?php if(empty($this->session->userdata('name') )){ ?>
        <button class="btn text-center" style="width:200px">login</button>
        <?php }else{ ?>
            welecome! <br/>
            <?=$this->session->userdata('name')?>
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
                        <button class="btn btn-toggle btn-toggle2 align-items-center rounded pb-1 small btn-toggle-nav"  data-bs-toggle="collapse" data-bs-target="#germany-collapse" aria-expanded="false">Germany</button>
                        <div class="collapse" id="germany-collapse">
                            <a href="/main/calendar?country=Germany"><span class="btn-toggle-nav list-unstyled fw-normal pb-1 small link-dark">Schedule</span></a>
                        </div>
                    </li>
                    <li>
                        <button class="btn btn-toggle btn-toggle2 align-items-center rounded pb-1 small btn-toggle-nav"  data-bs-toggle="collapse" data-bs-target="#france-collapse" aria-expanded="false">France</button>
                        <div class="collapse" id="france-collapse">
                            <a href="/main/calendar?country=France"><span class="btn-toggle-nav list-unstyled fw-normal pb-1 small link-dark">Schedule</span></a>
                        </div>
                    </li>
                    <li>
                        <button class="btn btn-toggle btn-toggle2 align-items-center rounded pb-1 small btn-toggle-nav"  data-bs-toggle="collapse" data-bs-target="#uk-collapse" aria-expanded="false">UK</button>
                        <div class="collapse" id="uk-collapse">
                            <a href="/main/calendar?country=UK"><span class="btn-toggle-nav list-unstyled fw-normal pb-1 small link-dark">Schedule</span></a>
                        </div>
                    </li>
                    <li>
                        <button class="btn btn-toggle btn-toggle2 align-items-center rounded pb-1 small btn-toggle-nav"  data-bs-toggle="collapse" data-bs-target="#poland-collapse" aria-expanded="false">Poland</button>
                      <div class="collapse" id="Poland-collapse">
                            <a href="main/calendar?country=Poland"><span class="btn-toggle-nav list-unstyled fw-normal pb-1 small link-dark">Schedule</span></a>
                        </div>
                    </li>                 
                    <li>
                        <button class="btn btn-toggle btn-toggle2 align-items-center rounded pb-1 small btn-toggle-nav " data-bs-toggle="collapse" data-bs-target="#czech-collapse" aria-expanded="false">Czech</button>
                        <div class="collapse" id="czech-collapse">
                            <a href="main/calendar?country=Czech"><span class="btn-toggle-nav list-unstyled fw-normal pb-1 small link-dark">Schedule</span></a>
                        </div>
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
                        <button class="btn btn-toggle btn-toggle2 align-items-center rounded pb-1 small btn-toggle-nav"  data-bs-toggle="collapse" data-bs-target="#germany-collapse" aria-expanded="false">Germany</button>
                        <div class="collapse" id="germany-collapse">
                            <a href="/main/calendar?country=Germany"><span class="btn-toggle-nav list-unstyled fw-normal pb-1 small link-dark">Schedule</span></a>
                        </div>
                    </li>
                    <li>
                        <button class="btn btn-toggle btn-toggle2 align-items-center rounded pb-1 small btn-toggle-nav"  data-bs-toggle="collapse" data-bs-target="#france-collapse" aria-expanded="false">France</button>
                        <div class="collapse" id="france-collapse">
                            <a href="/main/calendar?country=France"><span class="btn-toggle-nav list-unstyled fw-normal pb-1 small link-dark">Schedule</span></a>
                        </div>
                    </li>
                    <li>
                        <button class="btn btn-toggle btn-toggle2 align-items-center rounded pb-1 small btn-toggle-nav"  data-bs-toggle="collapse" data-bs-target="#uk-collapse" aria-expanded="false">UK</button>
                        <div class="collapse" id="uk-collapse">
                            <a href="/main/calendar?country=UK"><span class="btn-toggle-nav list-unstyled fw-normal pb-1 small link-dark">Schedule</span></a>
                        </div>
                    </li>
                    <li>
                        <button class="btn btn-toggle btn-toggle2 align-items-center rounded pb-1 small btn-toggle-nav"  data-bs-toggle="collapse" data-bs-target="#poland-collapse" aria-expanded="false">Poland</button>
                        <div class="collapse" id="poland-collapse">
                            <a href="/main/calendar?country=Poland"><span class="btn-toggle-nav list-unstyled fw-normal pb-1 small link-dark">Schedule</span></a>
                        </div>
                    </li>
                    <li>
                        <button class="btn btn-toggle btn-toggle2 align-items-center rounded pb-1 small btn-toggle-nav " data-bs-toggle="collapse" data-bs-target="#czech-collapse" aria-expanded="false">Czech</button>
                        <div class="collapse" id="czech-collapse">
                            <a href="/main/calendar?country=Czech"><span class="btn-toggle-nav list-unstyled fw-normal pb-1 small link-dark">Schedule</span></a>
                        </div>
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
    </ul>
</div>
<div class="b-example-divider"></div>