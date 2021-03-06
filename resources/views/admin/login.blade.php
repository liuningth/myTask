<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>登录页面-TASK后台管理系统</title>
    <link rel="stylesheet" href="/style/admin/bs/css/bootstrap.min.css">
    <script src="/style/admin/bs/js/jquery.min.js"></script>
    <script src="/style/admin/bs/js/bootstrap.min.js"></script>
    <style>
        .row{
            margin-top:200px;
        }
        .input-group{
            margin:10px 0px;
            width:100%;
            text-align:center;
        }

    </style>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        TASK后台登录页面
                    </h3>
                </div>

                <div class="panel-body">
                    <form action="/user/login" method="post">
                        {{csrf_field()}}
                        <div class="input-group">
                            <span class="input-group-addon"> <span class="glyphicon glyphicon-user"></span></span>
                            <input name="name" type="text" class="form-control" placeholder="Username">
                        </div>

                        <div class="input-group">
                            <span class="input-group-addon"> <span class="glyphicon glyphicon-lock"></span></span>
                            <input name="pass" type="password" class="form-control" placeholder="Username">
                        </div>


                        <div class="input-group" >
                            <input type="submit" value="提交" class="btn btn-sm btn-success">
                            &nbsp;
                            &nbsp;
                            <input type="reset" value="重置" class="btn btn-sm btn-danger">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>

</html>
