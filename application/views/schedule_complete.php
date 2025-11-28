<div class="content-wrapper">
    <section class="content-header">
        <h1>
            등록 처리 완료 🎉
            <small>미등록 항목 등록 결과</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('schedule'); ?>"><i class="fa fa-dashboard"></i> 홈</a></li>
            <li><a href="<?php echo site_url('schedule/excel'); ?>">엑셀 업로드</a></li>
            <li class="active">등록 결과</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">미등록 데이터 일괄 등록 결과 요약</h3>
                    </div>
                    <div class="box-body">
                        
                        <?php 
                        // 컨트롤러에서 flashdata로 넘겨준 결과 배열을 받습니다.
                        $results = $this->session->flashdata('registration_results');
                        
                        if (!empty($results)) {
                            // 성공적으로 등록된 항목 수 계산 (예시)
                            $success_count = count($results); 
                        ?>
                            
                            <p class="lead">
                                총 **<?php echo $success_count; ?>** 건의 미등록 Country, City, Company 데이터에 대한 등록 처리가 완료되었습니다.
                            </p>
                            
                            <hr>

                            <h4>처리 상세 내역</h4>
                            <ul class="list-group">
                                <?php foreach ($results as $result_message): ?>
                                    <li class="list-group-item">
                                        <i class="fa fa-check text-green"></i> 
                                        <?php echo htmlspecialchars($result_message); ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                            
                        <?php } else { ?>
                            <p class="lead text-danger">
                                등록할 데이터가 없거나, 처리 결과가 전달되지 않았습니다.
                            </p>
                            <p>
                                이전 단계에서 체크박스를 선택했는지 확인해주세요.
                            </p>
                        <?php } ?>
                        
                    </div>
                    <div class="box-footer">
                        <a href="<?php echo site_url('schedule/excel_upload_form'); ?>" class="btn btn-default">
                            <i class="fa fa-upload"></i> 다시 엑셀 업로드 하기
                        </a>
                        <a href="<?php echo site_url('schedule/list_page'); ?>" class="btn btn-info pull-right">
                            <i class="fa fa-list"></i> 등록된 데이터 목록 보기
                        </a>
                    </div>
                </div>
                </div>
        </div>
    </section>
</div>