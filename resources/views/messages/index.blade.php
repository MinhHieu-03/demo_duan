@extends('layouts.app')

@section('content')
<div class="container min-vh-100 py-4">
    <h5 class="text-center fw-bold" style="color: brown;">Hộp Thư</h5>
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="border rounded shadow-sm inbox-container">
                <div class="mb-2">        
                    <select class="form-select form-select-sm" name="receiver_id" required>
                        @foreach(App\Models\User::where('role', 'admin')->get() as $admin) 
                            <option value="{{ $admin->id }}">{{ $admin->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Danh sách tin nhắn -->
                <div class="inbox-messages">
                    @foreach($messages as $msg)
                        <div class="card mb-1 shadow-sm small-card">
                            <div class="card-body p-2">
                                <h6 class="fw-semibold small mb-1">{{ $msg->sender->name }}</h6>
                                <p class="mb-1 extra-small">{{ $msg->message }}</p>
                                <small class="text-muted">{{ $msg->created_at }}</small>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Form gửi tin nhắn cố định -->
                <form action="{{ route('messages.store') }}" method="POST" class="message-form d-flex align-items-center gap-2">
                    @csrf
                    <input type="hidden" name="receiver_id" value="{{ App\Models\User::where('role', 'admin')->first()->id }}">
                    <textarea class="form-control form-control-sm flex-grow-1" name="message" rows="1" required></textarea>
                    <button type="submit" class="btn btn-warning fw-bold btn-sm">Gửi</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

<style>
    /* Hộp thư */
    .inbox-container {
        background: linear-gradient(135deg,rgb(223, 176, 101), #1e90ff);
        color: white;
        height: 500px;
        display: flex;
        flex-direction: column;
        position: relative;
        border-radius: 15px;
        overflow: hidden;
        padding: 15px;
    }

    /* Danh sách tin nhắn cuộn */
    .inbox-messages {
        flex-grow: 1;
        overflow-y: auto;
        padding: 10px;
    }

    /* Card tin nhắn */
    .small-card {
        font-size: 0.85rem;
        border-radius: 15px;
        background: rgba(255, 255, 255, 0.9);
        transition: 0.3s;
    }

    .small-card:hover {
        transform: scale(1.02);
    }

    .small-card .card-body {
        padding: 10px;
    }

    /* Nhỏ chữ hơn */
    .extra-small {
        font-size: 0.8rem;
    }

    /* Form gửi tin nhắn cố định */
    .message-form {
        background: white;
        padding: 10px;
        border-radius: 10px;
        box-shadow: 0px -2px 5px rgba(0, 0, 0, 0.1);
    }

    /* Nút gửi tin nhắn */
    .btn-warning {
        background-color: #ff9800;
        border: none;
        border-radius: 10px;
    }

    .btn-warning:hover {
        background-color: #e68900;
    }

    /* Bo góc cho input và textarea */
    .form-control, textarea.form-control {
        border-radius: 10px;
        resize: none;
    }
    h5 {
        color: black;
    }
</style>
