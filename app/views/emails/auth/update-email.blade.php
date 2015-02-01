<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
</head>
<body>
<h3>Xin chào bạn {{$username}}</h3>

<div>
    <p>Bạn hoặc ai đó đã yêu cầu thay đổi email. Nếu đó không phải là bạn, hãy bỏ qua email này. Nếu bạn muốn thay đổi email mới, hãy click vào đường link bên dưới:</p>
    <p>{{URL::to('/users/update-email?time='.$time.'&id='.$id.'&new='.$new_email.'&token='.$token)}}</b></p>
</div>
<div>
    <p>Email này có thời hạn trong vòng 30 phút.</p>
</div>
</body>
</html>