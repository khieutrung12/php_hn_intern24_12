<div style="width: 600px; margin: 0 auto;">
    <div style="text-align: center;">
        <h2 style="text-align: center;">
            Xin chào, {{ Auth()->user()->name }}
        </h2>
        <p style="text-align: center;">
            Bạn đã đăng ký tài khoản tại hệ thống của chúng tôi,
        </p>
        <p style="text-align: center;">
            Để có thể tiếp tục sử dụng các dịch vụ, bạn vui lòng nhấn vào nút xác nhận bên dưới để kích hoạt tài khoản.
        </p>
        <a  href="{{ route('admin.active.email', [
                    'id' => Auth()->user()->id,
                    'token' => Auth()->user()->token, ]) }}"
            style=" display: inline-block;
                    background-color: #313A46;
                    color: white;
                    box-shadow: 1px 0 3px rgba(0, 0, 0, 0.15);
                    border-radius: 4px;
                    border: 2px solid #313A46;
                    padding: 5px;
                    margin-top: 5px;
                    cursor: pointer;">
            Xác thực
        </a>
    </div>
</div>
