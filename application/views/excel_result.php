<div class="content-wrapper">
    <section class="content-header">
        <h1>
            엑셀 업로드 처리 결과
            <small>미등록 항목 처리</small>
        </h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">전체 처리 결과</h3>
                    </div>
                    <div class="box-body table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>행 번호</th>
                                    <th>결과 코드</th>
                                    <th>처리 결과</th>
                                    <th>Company</th>
                                    <th>Country</th>
                                    <th>City</th>
                                    <th>Club Name</th>
                                    <th>시작일</th>
                                    <th>종료일</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $not_found_data = []; ?>
                                <?php foreach ($excel as $row_num => $item): ?>
                                    <tr>
                                        <td><?php echo $row_num; ?></td>
                                        <td>
                                            <?php if ($item['code'] == '1'): ?>
                                                <span class="label label-success">성공 (1)</span>
                                            <?php else: ?>
                                                <span class="label label-danger">실패 (0)</span>
                                                <?php $not_found_data[] = $item; // 실패한 데이터를 별도로 모음 ?>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="text-danger"><?php echo $item['result']; ?></span>
                                             <?php if ($item['code'] != '1'): ?>
                                                <?php 
                                                    // 에러 메시지에 포함된 단어로 어떤 버튼을 띄울지 결정
                                                    $result_msg = strtolower($item['result']); 
                                                ?>

                                                <?php if (strpos($result_msg, 'country') !== false): ?>
                                                    <button type="button" class="btn btn-xs btn-primary btn-register-country"
                                                        data-country="<?php echo htmlspecialchars($item['country']); ?>">
                                                        <i class="fa fa-plus"></i> Country 등록
                                                    </button>
                                                
                                                <?php elseif (strpos($result_msg, 'city') !== false): ?>
                                                    <button type="button" class="btn btn-xs btn-warning btn-register-city"
                                                        data-country="<?php echo htmlspecialchars($item['country']); ?>"
                                                        data-city="<?php echo htmlspecialchars($item['city']); ?>">
                                                        <i class="fa fa-plus"></i> City 등록
                                                    </button>

                                                <?php elseif (strpos($result_msg, 'space') !== false || strpos($result_msg, 'club') !== false): ?>
                                                    <button type="button" class="btn btn-xs btn-info btn-register-space"
                                                        data-country="<?php echo htmlspecialchars($item['country']); ?>"
                                                        data-city="<?php echo htmlspecialchars($item['city']); ?>"
                                                        data-space="<?php echo htmlspecialchars($item['space']); ?>" data-company="<?php echo htmlspecialchars($item['company']); ?>">
                                                        <i class="fa fa-plus"></i> Space 등록
                                                    </button>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo $item['company']; ?></td>
                                        <td><?php echo $item['country']; ?></td>
                                        <td><?php echo $item['city']; ?></td>
                                        <td><?php echo $item['space']; ?></td>
                                        <td><?php echo $item['open']; ?> <?php echo $item['open time']; ?></td>
                                        <td><?php echo $item['close']; ?> <?php echo $item['close time']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    </div>
                <hr>

                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">미등록 Country, City, Company 처리</h3>
                    </div>
                    <div class="box-body">
                        <?php if (count($not_found_data) > 0): ?>
                            <p>
                                DB에 존재하지 않는 **Country**, **City**, 또는 **Company** 정보로 인해 총
                                **<?php echo count($not_found_data); ?>** 건의 데이터 처리가 실패했습니다.
                            </p>
                        <?php else: ?>
                            <p class="text-success">모든 엑셀 데이터가 성공적으로 처리되었거나, 미등록 항목이 없습니다.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

</main>


<div class="modal fade" id="modalRegisterCountry" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Country 등록</h4>
            </div>
            <form action="<?php echo site_url('country/insert'); ?>" method="POST">
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Country Name</label>
                        <input type="text" class="form-control" name="country_name" id="modal_country_name" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">저장</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">닫기</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalRegisterCity" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">City 등록</h4>
            </div>
            <form action="<?php echo site_url('city/insert'); ?>" method="POST">
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Country</label>
                        <input type="text" class="form-control" name="country_name" id="modal_city_country" readonly>
                    </div>
                    <div class="form-group">
                        <label>City Name</label>
                        <input type="text" class="form-control" name="city_name" id="modal_city_name" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning">저장</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">닫기</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="genericIframeModal" tabindex="-1" role="dialog" aria-labelledby="genericModalLabel">
    <div class="modal-dialog modal-lg" role="document"> <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="genericModalLabel">항목 등록</h4>
            </div>
            <div class="modal-body" style="padding: 0;">
                <iframe id="registrationIframe" 
                        style="width: 100%; height: 500px; border: none;" 
                        src="" 
                        allowfullscreen>
                </iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">닫기</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        
    
    // 이전에 Mapbox 관련 코드가 있었다면 그대로 유지하거나 제거하세요.
    // 기존 go_home() 함수도 그대로 유지합니다.

    const BASE_URL = "<?php echo site_url('/'); ?>"; // CodeIgniter 기본 URL

    // 1. Country 등록 버튼 클릭
    $('.btn-register-country').on('click', function() {
        var country = $(this).data('country');
        
        // URL과 쿼리 스트링 조합 (예: /country/insert?country_name=Korea)
        var targetUrl = BASE_URL + 'country/insert?country_name=' + encodeURIComponent(country);
        
        loadIframeModal('Country 등록', targetUrl);
    });

    // 2. City 등록 버튼 클릭
    $('.btn-register-city').on('click', function() {
        var country = $(this).data('country');
        var city = $(this).data('city');
        
        // URL과 쿼리 스트링 조합 (예: /city/insert?country_name=Korea&city_name=Seoul)
        var targetUrl = BASE_URL + 'city/insert?country_name=' + encodeURIComponent(country) + 
                                          '&city_name=' + encodeURIComponent(city);
        
        loadIframeModal('City 등록', targetUrl);
    });

    // 3. Space 등록 버튼 클릭
    $('.btn-register-space').on('click', function() {
        var country = $(this).data('country');
        var city = $(this).data('city');
        var space = $(this).data('space');
        var company = $(this).data('company');
        
        // URL과 쿼리 스트링 조합
        var targetUrl = BASE_URL + 'space/insert?country_name=' + encodeURIComponent(country) + 
                                         '&city_name=' + encodeURIComponent(city) +
                                         '&space_name=' + encodeURIComponent(space) +
                                         '&company_name=' + encodeURIComponent(company);
        
        loadIframeModal('Space 등록', targetUrl);
    });
    
    // 범용 Iframe 모달 로드 함수
    function loadIframeModal(title, url) {
        $('#genericModalLabel').text(title);
        $('#registrationIframe').attr('src', url);
        $('#genericIframeModal').modal('show');
    }

    // 모달이 닫힐 때 iframe src를 초기화 (필수)
    $('#genericIframeModal').on('hidden.bs.modal', function () {
        $('#registrationIframe').attr('src', '');
        
        // 항목 등록 후 목록을 새로고침하려면 여기에 location.reload() 추가 가능
        // location.reload(); 
    });
});

    });

    function go_home(){
        location.href="/main";
    }
</script>