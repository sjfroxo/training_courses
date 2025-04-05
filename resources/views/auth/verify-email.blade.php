<div class="container">
    <p>Проверьте почту, на него должно прийти письмо с подтверждением аккаунта.</p>
    <p>Не пришло письмо?</p>
    <form action="{{ route('verification.send') }}" method="POST">
        @csrf
        @method('POST')

        <button class="btn-elprimary"
                style="color:#6f42c1;
                border: solid 1px #6f42c1;
                background: #fff;
                border-radius: 7px;
                padding: 10px;
                ">Отправить письмо еще раз.
        </button>
    </form>
</div>

