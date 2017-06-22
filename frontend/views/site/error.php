<!DOCTYPE html>
<html>
<head>
    <title>出错啦</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        .erropage {
            font-size: 100px;
            color: #c9caca;
            text-align: center;
            margin-top: 40%;
        }
        .erropage em{
            font-style: normal;
            font-size: 16px;
            color: #666666;
            display: block;
        }
    </style>
</head>

<body>
<div class="erropage">
    <?=$exception->statusCode?>
    <em><?=$message?></em>
</div>
</body>

</html>