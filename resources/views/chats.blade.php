@extends('layouts.app')

@section('main')
    <div class="container py-5">

        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-10 col-xl-10 mb-4 mb-md-0">
                <h5 class="font-weight-bold mb-3 text-center text-lg-start">Чаты</h5>
                <div class="card">
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            @foreach($chats as $chat)
                                <li class="p-2 border-bottom">
                                    <a href="{{route('chat.show', $chat->slug)}}"
                                       class="d-flex justify-content-between">
                                        <div class="d-flex flex-row">
                                            <div class="pt-1">
                                                <p class="fw-bold mb-0">{{$chat->title}}</p>
                                                <p class="small text-muted">{{$chat->lastMessage->message}}</p>
                                            </div>
                                        </div>
                                        <div class="pt-1">
                                            <p class="small text-muted mb-1">{{$chat->lastMessage->created_at->format('H:i')}}</p>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
