<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
</head>
<body>
<h3>Xin chào bạn {{$name}}</h3>

<div>
    <p>Bạn hoặc ai đó đã yêu cầu thay đổi mật khẩu. Nếu đó không phải là bạn, hãy bỏ qua email này. Nếu bạn muốn tạo mật khẩu mới, hãy click vào đường link bên dưới:</p>
    <p>{{URL::to('/users/reset-password?time='.$time.'&id='.$id.'&token='.$token)}}</b></p>
</div>
<div>
    <p>Email này có thời hạn trong vòng 30 phút.</p>
</div>
</body>
</html>