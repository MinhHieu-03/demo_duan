@extends('layouts.admin')

@section('content')
<div class="container">
    <h3 class="text-center">Hộp Thư Tin Nhắn</h3>

    <div class="row justify-content-center">
        <!-- Cột bên trái: Form trả lời -->
        <div class="col-md-5">
            @if(request('sender_id'))
                <div class="p-3 border rounded shadow-sm bg-light">
                    <h4 class="text-center">Trả Lời</h4>
                    <form action="{{ route('messages.reply') }}" method="POST">
                        @csrf
                        <input type="hidden" name="receiver_id" value="{{ request('sender_id') }}">
                        <div class="mb-3">
                            <textarea class="form-control" name="message" rows="5" required placeholder="Nhập tin nhắn..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Gửi</button>
                    </form>
                </div>
            @endif
        </div>

        <!-- Cột bên phải: Hộp thư & danh sách tin nhắn -->
        <div class="col-md-5">
            <div class="p-3 border rounded shadow-sm bg-white">
                <!-- Dropdown chọn người dùng -->
                <form method="GET" action="{{ route('admin.messages.index') }}">
                    <label for="sender_id">Chọn người dùng:</label>
                    <select name="sender_id" class="form-control" onchange="this.form.submit()">
                        <option value="">-- Chọn người dùng --</option>
                        @foreach($senders as $sender)
                            <option value="{{ $sender->id }}" {{ request('sender_id') == $sender->id ? 'selected' : '' }}>
                                {{ $sender->name }}
                            </option>
                        @endforeach
                    </select>
                </form>

                <!-- Hiển thị tin nhắn -->
                <div class="mt-3" style="max-height: 400px; overflow-y: auto;">
                    <h5 class="text-center">Tin Nhắn</h5>
                    @if($messages->isEmpty())
                        <p class="text-muted text-center">Chưa có tin nhắn nào.</p>
                    @else
                        @foreach($messages as $msg)
                            <div class="card mb-2 shadow-sm">
                                <div class="card-body">
                                    <strong>{{ $msg->sender->name }}:</strong>
                                    <p>{{ $msg->message }}</p>
                                    <small class="text-muted">{{ $msg->created_at }}</small>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
