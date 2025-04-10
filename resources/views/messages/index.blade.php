@extends('layouts.app')

@section('content')
<div class="container min-vh-100 py-4 d-flex flex-column">
    <h5 class="text-center fw-bold" style="color: brown;">Hộp Thư</h5>
    <div class="row justify-content-center flex-grow-1">
        <div class="col-md-7 d-flex flex-column">
            <div class="border rounded shadow-sm inbox-container">
                <!-- Danh sách tin nhắn -->
                <div class="inbox-messages">
                    @foreach($messages as $msg)
                        <div class="d-flex mb-2 {{ $msg->sender_id == auth()->id() ? 'justify-content-end' : 'justify-content-start' }}">
                            <div class="message-bubble {{ $msg->sender_id == auth()->id() ? 'sent' : 'received' }}">
                                <p class="mb-1 extra-small">{{ $msg->message }}</p>
                                <small class="text-muted">{{ $msg->created_at }}</small>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Form gửi tin nhắn -->
                <form id="messageForm" action="{{ route('messages.store') }}" method="POST" class="message-form d-flex align-items-center gap-2">
                    @csrf
                    <input type="hidden" name="receiver_id" value="{{ App\Models\User::where('role', 'admin')->first()->id }}">
                    <textarea id="messageInput" class="form-control form-control-sm flex-grow-1" name="message" rows="1" placeholder="Nhập tin nhắn..." required></textarea>
                    <button type="submit" class="btn btn-warning fw-bold btn-sm">Gửi</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const inboxMessages = document.querySelector('.inbox-messages');
        if (inboxMessages) {
            inboxMessages.scrollTop = inboxMessages.scrollHeight; // Cuộn xuống cuối danh sách
        }

        const messageInput = document.getElementById('messageInput');
        const messageForm = document.getElementById('messageForm');

        messageInput.addEventListener('keydown', function (event) {
            if (event.key === 'Enter' && !event.shiftKey) {
                event.preventDefault(); // Ngăn xuống dòng
                messageForm.submit(); // Gửi form
            }
        });
    });
</script>

<style>
    /* Hộp thư */
    .inbox-container {
        background: #f0f2f5;
        color: black;
        height: 500px; /* Giới hạn chiều cao khung chat */
        display: flex;
        flex-direction: column;
        border-radius: 15px;
        overflow: hidden;
        padding: 15px;
        position: relative;
    }

    /* Danh sách tin nhắn cuộn */
    .inbox-messages {
        flex-grow: 1;
        overflow-y: auto; /* Thêm cuộn dọc */
        padding: 10px;
        display: flex;
        flex-direction: column;
        max-height: 405px; /* Giới hạn chiều cao danh sách tin nhắn */
    }

    /* Tin nhắn */
    .message-bubble {
        max-width: 70%;
        padding: 10px;
        border-radius: 15px;
        font-size: 0.8rem;
        position: relative;
    }

    .message-bubble.sent {
        background: #d1e7dd;
        color: black;
        align-self: flex-end;
        border-top-right-radius: 0;
    }

    .message-bubble.received {
        background: #ffffff;
        color: black;
        align-self: flex-start;
        border-top-left-radius: 0;
    }

    /* Form gửi tin nhắn */
    .message-form {
        background: white;
        padding: 10px;
        border-radius: 10px;
        box-shadow: 0px -5px 5px rgba(0, 0, 0, 0.1);
        position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    z-index: 10;
    }

    /* Nút gửi tin nhắn */
    .btn-warning {
        background-color: #0084ff;
        border: none;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        justify-content: center;
        align-items: center;
        color: white;
    }

    .btn-warning:hover {
        background-color: #006dbf;
    }

    /* Bo góc cho input và textarea */
    .form-control, textarea.form-control {
        border-radius: 20px;
        resize: none;
    }
</style>
