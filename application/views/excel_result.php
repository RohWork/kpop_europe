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

</main>

<script>
    function go_home(){
        location.href="/main";
    }
</script>