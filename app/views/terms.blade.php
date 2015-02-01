@extends('layouts.default')

@section('title')
Thỏa thuận sử dụng
@endsection

@section('content')
<main>
    <div class="container">
        <div class="terms row">
            <section class="terms-menu col-sm-4">
                <h3>Thỏa thuận sử dụng</h3>
                <ul class="terms-list list-unstyled">
                    <li class="active"><a href="javascript:;">Điều 1: Giải thích từ ngữ</a></li>
                    <li><a href="javascript:;">Điều 2: Nguyên tắc đăng ký tài khoản MaxGate ID</a></li>
                    <li><a href="javascript:;">Điều 3: Các hành vi cấm</a></li>
                    <li><a href="javascript:;">Điều 4: Đăng ký</a></li>
                    <li><a href="javascript:;">Điều 5: Sử dụng tài khoản, mật khẩu</a></li>
                    <li><a href="javascript:;">Điều 6: Đăng nhập</a></li>
                    <li><a href="javascript:;">Điều 7: Quyền của chủ tài khoản</a></li>
                    <li><a href="javascript:;">Điều 8: Trách nhiệm của chủ tài khoản</a></li>
                    <li><a href="javascript:;">Điều 9: Quyền của MAXGATE</a></li>
                    <li><a href="javascript:;">Điều 10: Trách nhiệm của MAXGATE</a></li>
                </ul>
            </section>
            <section class="terms-content col-sm-8">
                <ul class="list-unstyled">
                    <li class="active">
                        <h3>Điều 1: Giải thích từ ngữ</h3>
                        <section>
                            <p><b>Tài khoản MaxGate ID:</b> Là tài khoản để truy cập sử dụng một phần hoặc tất cả các sản phẩm của MAXGATE.</p>
                            <p><b>Chủ tài khoản:</b> Là người sở hữu hợp pháp tài khoản MaxGate ID.</p>
                            <p><b>MAXGATE:</b> Là sản phẩm của Công ty Cổ phần Dịch vụ Trực tuyến Phúc Thành.</p>
                            <p><b>Giấy tờ tùy thân:</b> Giấy tờ tùy thân theo quy định trong Quy chế này là một trong các giấy tờ sau: Chứng minh nhân dân, Hộ chiếu, Giấy phép lái xe.</p>
                            <p><b>Mã số tài khoản:</b> Đây là mã số tương ứng với mỗi tên đăng nhập cho tài khoản. Mã số này dùng để giúp bạn đảm bảo không bị lộ tên đăng nhập khi thực hiện các giao dịch mua MaxGateXu. Khi giao dịch mua MaxGateXu bạn có thể cung cấp mã số tài khoản thay vì sử dụng tên đăng nhập.</p>
                            <p><b>OTP:</b> One Time Password - là mật khẩu dùng một lần. OTP Mobile là ứng dụng tạo mật khẩu dùng một lần do MAXGATE phát triển nhằm hạn chế rủi ro có thể xảy ra khi đăng nhập tài khoản MaxGate ID.</p>
                            <p><b>Tài khoản liên kết:</b> Là việc dùng tài khoản của Yahoo, Google và Facebook để đăng nhập vào tài khoản MaxGate ID.</p>
                        </section>
                    </li>
                    <li>
                        <h3>Điều 2: Nguyên tắc đăng ký tài khoản MaxGate ID</h3>
                        <section>
                            <p>Bạn phải chịu trách nhiệm hoàn toàn trước mọi thông tin đăng ký tài khoản MaxGate ID, thông tin sửa đổi, bổ sung tài khoản MaxGate ID.</p>
                            <p>Ngoài việc tuân thủ Quy chế sử dụng MaxGate ID này, bạn phải chấp hành nghiêm chỉnh các thỏa thuận, quy định, quy trình khác của MAXGATE khi sử dụng sản phẩm của MAXGATE được đăng tải công khai trên website sản phẩm của MAXGATE.</p>
                            <p>Bạn không được đặt tài khoản theo tên của danh nhân, tên các vị lãnh đạo của Đảng và Nhà nước, tên của cá nhân, tổ chức tội phạm, phản động, khủng bố hoặc tài khoản có ý nghĩa không lành mạnh, trái với thuần phong mỹ tục.</p>
                            <p>Khi sử dụng sản phẩm của MAXGATE, bạn phải lựa chọn sử dụng sản phẩm phù hợp với độ tuổi và chấp hành nghiêm chỉnh các thỏa thuận của từng sản phẩm được đăng công khai trên website của sản phẩm đó.</p>
                        </section>
                    </li>
                    <li>
                        <h3>Điều 3: Các hành vi cấm</h3>
                        <section>
                            <p>Lợi dụng việc cung cấp, sử dụng dịch vụ Internet và thông tin trên mạng nhằm mục đích:</p>
                            <p>Tiết lộ bí mật nhà nước, bí mật quân sự, an ninh, kinh tế, đối ngoại và những bí mật khác do pháp luật quy định.</p>
                            <p>Đưa thông tin xuyên tạc, vu khống, xúc phạm uy tín của tổ chức, danh dự và nhân phẩm của cá nhân.</p>
                            <p>Quảng cáo, tuyên truyền, mua bán hàng hoá, dịch vụ bị cấm; truyền bá tác phẩm báo chí, văn học, nghệ thuật, xuất bản phẩm bị cấm.</p>
                            <p>Cản trở trái pháp luật, gây rối, phá hoại hệ thống máy chủ tên miền quốc gia, hệ thống thiết bị cung cấp dịch vụ Internet và thông tin trên mạng; cản trở việc truy cập thông tin và sử dụng các dịch vụ hợp pháp trên Interrnet của tổ chức, cá nhân.</p>
                            <p>Sử dụng trái phép mật khẩu, khoá mật mã của các tổ chức, cá nhân, thông tin riêng, thông tin cá nhân và tài nguyên Internet.</p>
                            <p>Giả mạo tổ chức, cá nhân và phát tán thông tin giả mạo, thông tin sai sự thật trên mạng xâm hại đến quyền và lợi ích hợp pháp của tổ chức, cá nhân.</p>
                            <p>Tạo đường dẫn trái phép đối với tên miền của tổ chức, cá nhân. Tạo, cài đặt, phát tán các phần mềm độc hại, vi rút máy tính; xâm nhập trái phép, chiếm quyền điều khiển hệ thống thông tin, tạo lập công cụ tấn công trên Internet.</p>
                            <p>Tuyệt đối không sử dụng bất kỳ chương trình, công cụ hay hình thức nào khác để can thiệp vào sản phẩm của MAXGATE.</p>
                            <p>Nghiêm cấm việc phát tán, truyền bá hay cổ vũ cho bất kỳ hoạt động nào nhằm can thiệp, phá hoại hay xâm nhập vào dữ liệu của sản phẩm cung cấp hoặc hệ thống máy chủ.</p>
                            <p>Không được có bất kỳ hành vi nào nhằm đăng nhập trái phép hoặc tìm cách đăng nhập trái phép hoặc gây thiệt hại cho hệ thống máy chủ.</p>
                            <p>Không chấp nhận việc mua bán tài khoản MaxGate ID bằng tiền thật hoặc hiện kim.</p>
                            <p>Tuyệt đối nghiêm cấm việc xúc phạm, nhạo báng người khác dưới bất kỳ hình thức nào (nhạo báng, chê bai, kỳ thị tôn giáo, giới tính, sắc tộc….).</p>
                            <p>Không có những hành vi, thái độ làm tổn hại đến uy tín các sản phẩm của MAXGATEdưới bất kỳ hình thức hoặc phương thức nào.</p>
                            <p>Nghiêm cấm quảng bá bất kỳ sản phẩm dưới bất kỳ hình thức nào, bao gồm nhưng không giới bạn việc gửi, truyền bất kỳ thông điệp nào mang tính quảng cáo, mời gọi, thư dây truyền, cơ hội đầu tư trên sản phẩm của MAXGATE mà không có sự đồng ý bằng văn bản của MAXGATE.</p>
                            <p>Nghiêm cấm tổ chức các hình thức cá cược, cờ bạc hoặc các thỏa thuận liên quan đến tiền, hiện kim, hiện vật.</p>
                            <p>Nghiêm cấm mọi hành vi phá hoại sản phẩm của MAXGATE dưới mọi hình thức</p>
                        </section>
                    </li>
                    <li>
                        <h3>Điều 4: Đăng ký</h3>
                        <section>
                            <p>Trước khi đăng ký tài khoản, bạn xác nhận đã đọc, hiểu và đồng ý với tất cả các quy định trong Quy chế sử dụng MaxGate ID.</p>
                            <p>Khi đăng ký tài khoản, bạn cung cấp đầy đủ, chính xác thông tin về họ tên, tuổi, địa chỉ liên lạc, giấy tờ tùy thân, Email đăng ký tài khoản, Số điện thoại bảo vệ tài khoản, Câu hỏi và câu trả lời bảo mật và chịu trách nhiệm các thông tin mà bạn cung cấp. Bạn có thể đăng ký tài khoản liên kết để sử dụng việc đăng nhập tài khoản MaxGate ID.</p>
                            <p>Nếu phát sinh rủi ro trong quá trình sử dụng, MAXGATE căn cứ vào những thông tin bạn cung cấp để tiếp nhận và giải quyết. </p>
                            <p>MAXGATE chỉ tiếp nhận và giải quyết những trường hợp điền đúng, chính xác và đầy đủ những thông tin quy định tại khoản 2 điều này. Những trường hợp điền không đầy đủ và chính xác thông tin quy định tại khoản 2 điều này, bạn sẽ không nhận được bất kỳ sự hỗ trợ nào từ MAXGATE trong quá trình sử dụng và MAXGATE sẽ không chịu trách nhiệm giải quyết những tranh chấp, rủi ro phát sinh đối với tài khoản này.</p>
                        </section>
                    </li>
                    <li>
                        <h3>Điều 5: Sử dụng tài khoản, mật khẩu</h3>
                        <section>
                            <p>Sau khi hoàn tất thủ tục đăng ký, bạn sẽ được cung cấp 01 tài khoản và mã số tài khoản. Với tài khoản này, người sử dụng có thể truy cập và sử dụng một phần hoặc tất cả các sản phẩm của MAXGATE.</p>
                            <p>Đối với một tài khoản, chủ tài khoản sẽ có một mật khẩu cấp 1 và mật khẩu cấp 2. Mật khẩu cấp 2 dùng để lấy lại được mật khẩu cấp một khi cần.</p>
                            <p>Chủ tài khoản có trách nhiệm phải tự bảo quản mật khẩu cấp 1 và mật khẩu cấp 2 của mình, nếu mật khẩu cấp 1 hoặc mật khẩu cấp 2 bị lộ ra ngoài dưới bất kỳ hình thức nào, MAXGATE sẽ không chịu trách nhiệm về mọi tổn thất phát sinh.</p>
                            <p>MAXGATE có quyền xóa các tài khoản của người sử dụng nếu tài khoản này không được sử dụng để đăng nhập vào bất cứ một sản phẩm nào của MAXGATE sau 30 ngày kể từ ngày đăng ký.</p>
                            <p>MAXGATE có quyền xóa các tài khoản của người sử dụng nếu tài khoản này không được sử dụng để đăng nhập vào bất cứ một sản phẩm nào của MAXGATE trong 1 (một) năm tính từ lần sử dụng cuối cùng.</p>
                        </section>
                    </li>
                    <li>
                        <h3>Điều 6: Đăng nhập</h3>
                        <section>
                            <p>Bạn sẽ dùng tài khoản do mình đăng ký và được MAXGATE cung cấp để đăng nhập và sử dụng một phần hoặc tất cả các sản phẩm của MAXGATE.</p>
                            <p>Ngoài việc dùng tài khoản MaxGate ID để đăng nhập, bạn có thể dụng số điện thoại, Email, hoặc tài khoản liên kết để đăng nhập vào MaxGate ID. Khi sử dụng tính năng tiện ích này, bạn đồng ý chấp nhận tất cả những rủi ro tiềm ẩn xảy ra.</p>
                            <p>Để đăng nhập MaxGate ID từ tài khoản liên kết, bạn phải thực hiện các bước đăng ký liên kết tài khoản và chấp nhận thỏa thuận sử dụng tích năng này với . Bạn khẳng định đã đọc, hiểu rõ và chấp nhận những tiện ích cũng như rủi ro khi sử dụng tính năng đăng nhập này.</p>
                        </section>
                    </li>
                    <li>
                        <h3>Điều 7: Quyền của chủ tài khoản</h3>
                        <section>
                            <p>Bạn được quyền thay đổi, bổ sung thông tin tài khoản; Mật khẩu cấp 1; Mật khầu cấp 2; Giấy tờ tùy thân; Email đã đăng ký; Câu hỏi và câu trả lời bảo mật và Số điện thoại bảo vệ tài khoản.</p>
                            <p>Bạn được hướng dẫn cách đặt mật khẩu an toàn; sử dụng bàn phím ảo; nhập các thông tin quan trọng để bảo vệ tài khoản; bổ sung, thay đổi số điện thoại nạp MaxGateXu bằng Số điện thoại bảo vệ tài khoản; đăng ký Số điện thoại bảo vệ tài khoản; khóa tài khoản; sử dụng ứng dụng OTP khi đăng nhập tài khoản; sử dụng tài khoản liên kết để đăng nhập tài khoản.</p>
                            <p>Bạn được quyền tặng cho Tài khoản MaxGate ID cho người khác. Quyền được tặng cho tài khoản chỉ được áp dụng đối với tài khoản đã đăng ký đầy đủ và chính xác các thông tin tài khoản theo quy định Quy chế sử dụng MaxGate ID này. Việc tặng cho tài khoản MaxGate ID phải tuân thủ theo quy trình được đăng tải công khai trên trang hỗ trợ
                                <a href="http://hotro.maxgate.vn" target="_blank">http://hotro.MaxGate.vn</a>.</p>
                            <p>Được sử dụng các dịch vụ khác của MAXGATE được quy định tại <a href="http://hotro.maxgate.vn" target="_blank">http://hotro.MaxGate.vn</a>.</p>
                            <p>Được thực hiện các quyền khác theo quy định pháp luật.</p>
                        </section>
                    </li>
                    <li>
                        <h3>Điều 8: Trách nhiệm của chủ tài khoản</h3>
                        <section>
                            <p>Để nhận được sự hỗ trợ từ MAXGATE, tài khoản của bạn phải đăng ký đầy đủ các thông tin trung thực, chính xác. Nếu có sự thay đổi, bổ sung về thông tin, bạn cập nhật ngay cho chúng tôi theo hướng dẫn được quy định trên website http://hotro.MaxGate.vn/. Bạn đảm bảo rằng, thông tin hiện trạng của bạn là mới nhất, đầy đủ, trung thực và chính xác và bạn phải chịu trách nhiệm toàn bộ các thông tin bạn cung cấp.</p>
                            <p>Bạn có trách nhiệm bảo mật thông tin tài khoản bao gồm: Mật khẩu, số điện thoại bảo vệ tài khoản, giấy tờ tùy thân, Email bảo vệ tài khoản và tài khoản liên kết. Nếu những thông tin trên bị tiết lộ dưới bất kỳ hình thức nào thì bạn phải chấp nhận những rủi ro phát sinh. MAXGATE sẽ căn cứ vào những thông tin hiện có trong tài khoản để làm căn cứ quyết định chủ sở hữu tài khoản nếu có tranh chấp và MAXGATE sẽ không chịu trách nhiệm về mọi tổn thất phát sinh. Thông tin Giấy tờ tùy thân đăng ký trong tài khoản là thông tin quan trọng nhất để chứng minh chủ sở hữu tài khoản.</p>
                            <p>Bạn đồng ý sẽ thông báo ngay cho MAXGATE về bất kỳ trường hợp nào sử dụng trái phép tài khoản và mật khẩu của bạn hoặc bất kỳ các hành động phá vỡ hệ thống bảo mật nào. Bạn cũng bảo đảm rằng, bạn luôn thoát tài khoản của mình sau mỗi lần sử dụng.
                                MAXGATE quan tâm tới sự an toàn và riêng tư của tất cả thành viên đăng ký tài khoản và sử dụng sản phẩm của mình, đặc biệt là trẻ em. Vì vậy, nếu bạn là cha mẹ hoặc người giám hộ hợp pháp, bạn có trách nhiệm xác định xem sản phẩm, nội dung nào của MAXGATE thích hợp cho con của bạn. Tương tự, nếu bạn là trẻ em thì phải hỏi ý kiến cha mẹ hoặc người giám hộ hợp pháp của bạn xem sản phẩm, nội dung mà bạn sử dụng có phù hợp với bạn không.
                            </p>
                            <p>Khi phát hiện ra lỗi của sản phẩm , các vấn đề gây ảnh hưởng tới hoạt động bình thường của MAXGATE cũng như các sản phẩm liên quan, bạn hãy thông báo cho chúng tôi qua đường dây nóng 1900 561 558 hoặc qua website <a href="http://hotro.maxgate.vn" target="_blank">http://hotro.MaxGate.vn</a>.</p>
                            <p>Bạn cam kết thực hiện trách nhiệm bảo đảm sử dụng hợp pháp nội dung thông tin số đưa lên đăng tải trên hệ thống mạng Internet và mạng viễn thông.</p>
                            <p>Bạn có thể sẽ bị xử phạt vi phạm hành chính, bị truy tố trách nhiệm hình sự nếu bạn vi phạm về quyền tác giả, quyền liên quan khi bạn sử dụng mạng xã hội trực tuyến của MAXGATE.</p>
                            <p>Bạn phải tuân thủ tuyệt đối quy định tại Điều 3 thỏa thuận này về các hành vi cấm. Nếu vi phạm một hoặc nhiều hành vi, tùy thuộc vào mức độ vi phạm MAXGATE sẽ khóa tài khoản vĩnh viễn, tước bỏ mọi quyền lợi của bạn đối các sản phẩm của MAXGATE và sẽ yêu cầu cơ quan chức năng truy tố bạn trước pháp luật nếu cần thiết.</p>
                            <p>Thực hiện trách nhiệm khác theo quy định pháp luật.</p>
                        </section>
                    </li>
                    <li>
                        <h3>Điều 9: Quyền của MAXGATE</h3>
                        <section>
                            <p>Nếu bạn cung cấp bất kỳ thông tin nào không trung thực, không chính xác, hoặc nếu chúng tôi có cơ sở để nghi ngờ rằng thông tin đó không chính xác hoặc nếu bạn vi phạm bất cứ điều khoản nào trong quy chế sử dụng MaxGate ID này hoặc thỏa thuận sử dụng sản phẩm khác của MAXGATE được quy định trên website, chúng tôi có toàn quyền chấm dứt, xóa bỏ tài khoản của bạn mà không cần sự đồng ý của bạn và không phải chịu bất cứ trách nhiệm nào đối với bạn.</p>
                            <p>Mọi vi phạm của chủ tài khoản trong quá trình sử dụng sản phẩm của MAXGATE, MAXGATE có quyền tước bỏ mọi quyền lợi của chủ tài khoản đối với việc sử dụng các sản phẩm của MAXGATE cũng như sẽ yêu cầu cơ quan chức năng truy tố bạn trước pháp luật nếu cần thiết.</p>
                            <p>Khi phát hiện những vi phạm như sử dụng cheats, hacks, hoặc những lỗi khác, MAXGATE có quyền sử dụng những thông tin mà bạn cung cấp khi đăng ký tài khoản để chuyển cho Cơ quan chức năng giải quyết theo quy định của pháp luật.</p>
                            <p>MAXGATE có quyền từ chối hỗ trợ, giải quyết đối với tài khoản đăng ký thông tin không chính xác, đầy đủ theo quy định tại khoản khoản 2 điều 4 và đối với những tài khoản vi phạm trách nhiệm bảo mật tài khoản được quy định tại khoản 2 điều 8 quy chế này.</p>
                        </section>
                    </li>
                    <li>
                        <h3>Điều 10: Trách nhiệm của MAXGATE</h3>
                        <section>
                            <p>Có trách nhiệm hỗ trợ chủ tài khoản trong quá trình sử dụng sản phẩm của MAXGATE.</p>
                            <p>Nhận và giải quyết khiếu nại của khách hàng các trường hợp phát sinh trong quá trình sử dụng sản phẩm của MAXGATE, tuy nhiên MAXGATE chỉ hỗ trợ, nhận và giải quyết đối với tài khoản đăng ký đầy đủ thông tin, trung thực và chính xác.</p>
                            <p>Có trách nhiệm bảo mật thông tin cá nhân của chủ tài khoản, MAXGATE không bán hoặc trao đổi những thông tin này với bên thứ 3, trừ trường hợp theo quy định pháp luật hoặc được chủ tài khoản chấp nhận.</p>
                        </section>
                    </li>
                </ul>
            </section>
        </div>

    </div>
</main>

<script>
    $(function(){
        $(".terms-content ul li:gt(0)").hide();
        $(".terms-menu ul li").each(function(e){
            $(this).click(function(){
                $(".terms-menu ul li").removeClass('active');
                $(this).addClass('active');
                $(".terms-content ul li").hide();
               $(".terms-content ul li").eq(e).show();
            });
        });
    })
</script>
@endsection