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
                                        <td><?php echo $item['result']; ?></td>
                                        <td><?php echo $item['company']; ?></td>
                                        <td><?php echo $item['country']; ?></td>
                                        <td><?php echo $item['city']; ?></td>
                                        <td><?php echo $item['club name']; ?></td>
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
                            <p>
                                해당 항목들을 확인하고 일괄 등록하시겠습니까?
                            </p>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#notFoundModal">
                                미등록 항목 등록/확인 (<?php echo count($not_found_data); ?> 건)
                            </button>
                        <?php else: ?>
                            <p class="text-success">모든 엑셀 데이터가 성공적으로 처리되었거나, 미등록 항목이 없습니다.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal fade" id="notFoundModal" tabindex="-1" role="dialog" aria-labelledby="notFoundModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="notFoundModalLabel">미등록 Country, City, Company 정보</h4>
            </div>
            <div class="modal-body">
                <p>아래 목록은 DB에 존재하지 않아 등록이 실패한 항목들입니다. 등록할 데이터를 선택하고 **일괄 등록**을 진행하세요.</p>
                <form id="register_not_found_form" method="POST" action="<?php echo site_url('your_controller/register_missing_data'); ?>">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="check_all_register"></th>
                                <th>실패 사유</th>
                                <th>Country</th>
                                <th>City</th>
                                <th>Company</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            // 중복 제거를 위해 고유한 미등록 항목만 추출
                            $unique_not_found = [];
                            foreach ($not_found_data as $data) {
                                // 실패 사유에 따라 고유 키 생성
                                $key = $data['result'] . '|' . $data['country'] . '|' . $data['city'] . '|' . $data['company'];
                                $unique_not_found[$key] = [
                                    'country' => $data['country'],
                                    'city' => $data['city'],
                                    'company' => $data['company'],
                                    'reason' => $data['result']
                                ];
                            }
                            ?>
                            <?php foreach ($unique_not_found as $key => $data): ?>
                                <tr>
                                    <td><input type="checkbox" name="register_data[]" value="<?php echo htmlspecialchars($data['country'] . '|' . $data['city'] . '|' . $data['company']); ?>" checked></td>
                                    <td><span class="text-danger"><?php echo $data['reason']; ?></span></td>
                                    <td><?php echo $data['country']; ?></td>
                                    <td><?php echo $data['city']; ?></td>
                                    <td><?php echo $data['company']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">닫기</button>
                <button type="submit" form="register_not_found_form" class="btn btn-success">선택 항목 일괄 등록</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Mapbox Access Token을 여기에 입력하세요.
    const MAPBOX_ACCESS_TOKEN = 'pk.eyJ1Ijoic2h4b2R3ayIsImEiOiJjbWRheXdjOWQwbnZhMmpwa3EyenB6Z2RsIn0.jYcv95SmixAIKIdT4Te6uw'; 

    $(document).ready(function() {
        // 일괄 선택/해제 기능 (기존 로직 유지)
        $('#check_all_register').change(function() {
            $('input[name="register_data[]"]').prop('checked', $(this).prop('checked'));
        });
        
        // Mapbox Geocoding API를 호출하는 함수
        function geocodeAddress(address, rowIndex) {
            if (!MAPBOX_ACCESS_TOKEN || MAPBOX_ACCESS_TOKEN === 'YOUR_MAPBOX_ACCESS_TOKEN') {
                alert('Mapbox Access Token을 먼저 설정해주세요.');
                return;
            }
            
            // Mapbox Geocoding API 호출 URL
            const url = `https://api.mapbox.com/geocoding/v5/mapbox.places/${encodeURIComponent(address)}.json?access_token=${MAPBOX_ACCESS_TOKEN}`;
            
            const $row = $('tr[data-index="' + rowIndex + '"]');

            $.ajax({
                url: url,
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    if (data.features && data.features.length > 0) {
                        // Mapbox는 [경도, 위도] 순서로 좌표를 반환합니다.
                        const longitude = data.features[0].center[0]; 
                        const latitude = data.features[0].center[1];
                        
                        // 필드에 위도/경도 값 채우기
                        $row.find('.lat-field').val(latitude);
                        $row.find('.lon-field').val(longitude);

                        alert(`좌표 검색 성공: 위도 ${latitude}, 경도 ${longitude}`);
                    } else {
                        alert('Mapbox에서 검색된 결과가 없습니다: ' + address);
                    }
                },
                error: function(xhr, status, error) {
                    alert('좌표 검색 실패: Mapbox API 호출 오류');
                    console.error('Mapbox Geocode failed:', error);
                }
            });
        }

        // '좌표 검색' 버튼 클릭 이벤트 (기존 로직 유지)
        $('.geocode-btn').on('click', function(e) {
            e.preventDefault();
            const address = $(this).data('address');
            const rowIndex = $(this).data('index');
            
            geocodeAddress(address, rowIndex);
        });
    });
</script>
</main>

<script>
    function go_home(){
        location.href="/main";
    }
</script>