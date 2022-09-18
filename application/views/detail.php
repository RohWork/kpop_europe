<html>
    <head>
        <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <div class="container" style="font-size: 12px">
            <div class="row">
                <div class="col-2">
                    <label class="form-label">행사명</label>
                </div>
                <div class="col-10">
                    <p><?=$detail_info['name']?></p>
                </div>
            </div>
            <div class="row">
                <div class="col-2">
                    <label class="form-label">주관업체</label>
                </div>
                <div class="col-10">
                    <p><?=$detail_info['company']?></p>
                </div>
            </div>
            <div class="row">
                <div class="col-2">
                    <label class="form-label">홈페이지</label>
                </div>
                <div class="col-10">
                    <a href="<?=$detail_info['homepage']?>?>"><?=$detail_info['homepage']?></a>
                </div>
            </div>
            <div class="row">
                <div class="col-2">
                    <label class="form-label">행사위치</label>
                </div>
                <div class="col-10">
                    <p><?=$detail_info['addr']?></p>
                </div>
            </div>
            <div class="row">
                <div class="col-2">
                    <label class="form-label">페이스북주소</label>
                </div>
                <div class="col-10">
                    <a href="<?=$detail_info['face']?>?>"><?=$detail_info['face']?></a>
                </div>
            </div>
            <div class="row">
                <div class="col-2">
                    <label class="form-label">인스타그램주소</label>
                </div>
                <div class="col-10">
                    <a href="<?=$detail_info['insta']?>?>"><?=$detail_info['insta']?></a>
                </div>
            </div>
            <div class="row">
                <div class="col-2">
                    <label class="form-label">유튜브주소</label>
                </div>
                <div class="col-10">
                    <a href="<?=$detail_info['yout']?>?>"><?=$detail_info['yout']?></a>
                </div>
            </div>
            <div class="row">
                <div class="col-2">
                    <label class="form-label">행사기간</label>
                </div>
                <div class="col-10">
                    <p><?=$detail_info['start_date']?> ~ <?=$detail_info['end_date']?></p>
                </div>
            </div>
        </div>
    </body>
</html>