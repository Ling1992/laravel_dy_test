<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="{{ asset('bootstrap/assets/css/ie10-viewport-bug-workaround.css') }}" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="{{ asset('bootstrap/assets/js/ie8-responsive-file-warning.js') }}"></script><![endif]-->
    <script src="{{ asset('bootstrap/assets/js/ie-emulation-modes-warning.js') }}"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.7.1/slick.css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('bootstrap-datetimepicker/bootstrap-datetimepicker.css') }}"/>

    <style type="text/css">

    </style>
</head>
<body>
<div class="container">
    <div class="row" style="margin-top: 40px">
        <form action="/ipList" method="GET" id="search_form">
            <div class="col-lg-12">
                <div role="form" class="form-inline">
                    <div class="form-group col-lg-4" style="margin-bottom:5px;">
                        <label>日志时间：</label>
                        <input readonly  type="text" class="form-control datetime-picker" name="create_date" value="{{ $create_date }}">
                    </div>

                    <div class="form-group col-lg-4 col-lg-offset-4">
                        <button type="submit" class="btn btn-default" id="search_btn">查询</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="row" style="margin-top: 40px">
        <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead>
                <tr>
                    <th>日统计数</th>
                    <th>统计时间</th>
                    <th>ip</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach( $list as $l )
                    <tr>
                        <td>{{ $l->count }}</td>
                        <td>{{ $l->create_date }}</td>
                        <td>{{ $l->ip }}</td>
                        <td>
                            <a href="/ipDetail/{{ $l->ip }}/{{ $l->create_date }}" class="btn btn-link">详情</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div><!-- /.container -->

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="http://lib.sinaapp.com/js/jquery/1.12.4/jquery-1.12.4.min.js"></script>
<script>window.jQuery || document.write('<script src="{{ asset('bootstrap/assets/js/vendor/jquery.min.js') }}"><\/script>')</script>
<script src="{{ asset('bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('bootstrap-datetimepicker/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ asset('bootstrap-datetimepicker/bootstrap-datetimepicker.fr.js') }}"></script>
<script src="{{ asset('bootstrap-datetimepicker/bootstrap-datetimepicker.zh-CN.js') }}"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="{{ asset('bootstrap/assets/js/ie10-viewport-bug-workaround.js') }}"></script>

<script>
    $('#search_form .datetime-picker').datetimepicker({
        language:  'zh-CN',
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayBtn: true,
        forceParse: true,
        todayHighlight: true,
        startView:2,
        minView: 2,
        showMeridian:true,
        minuteStep: 10
    });
</script>

</body>
</html>
