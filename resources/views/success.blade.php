<?php
$url = env('APP_URL');
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <a href="{{route('top')}}">topに戻る</a><br>


  <script>
    window.onpopstate = function(event) {
      window.location.href = "{{$url}}";
    };
  </script>
</body>

</html>

成功しました。
{{request()->query('redirect_status')}}