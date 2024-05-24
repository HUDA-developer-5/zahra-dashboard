@extends('frontend.layouts.master')

@section("style")
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/record-style.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/style.min.css') }}">
@endsection

@section('content')

    <div id="main-wrapper">
        <div class="container">
            <div id="chat" class="my-5">
                <div class="row">
                    <div class="col-lg-5 mb-3 mb-lg-0">
                        <div id="chat-messages">
                            <div class="top-side">
                                <h6 class="fw-bold">{{ trans('web.inbox') }} <span class="text-primary fw-400">({{ $total_unread_messages }})</span>
                                </h6>
                                {{ html()->form('get', route('web.chats.list'))->open() }}
                                    <div class="search-input mb-2">
                                        <input type="text" name="search" id="filter-search" class="form-control"
                                               placeholder="{{ trans('web.Search') }}">
                                        <span class="icon"><i class="fas fa-magnifying-glass"></i></span>
                                    </div>
                                {{ html()->form()->close() }}
                            </div>
                            <div class="all-users-chat">
                                @if($chats->count())
                                    @foreach($chats as $chat)
                                        <div class="user-message @if($loop->first) active @endif"
                                             data-id="{{ $chat->id }}" onclick="showChatContent({{ $chat->id }})"
                                             id="Chat_{{$chat->id}}">
                                            <div class="d-flex align-items-center gap-3 user-content">
                                                <div class="user_img">
                                                    <img src="{{ $chat->sender_avatar }}" alt="image" class="img-fluid">
                                                </div>
                                                <div class="chat-body flex-grow-1 mt-1">
                                                    <div class="d-flex justify-content-between">
                                                        <h6 class="text-dark fw-600 mb-0">{{ $chat->sender_name }}</h6>
                                                        <p class="date fs-7 text-gray text-end text-md-left mb-0"><span
                                                                    class="time">{{ $chat->messages?->last()?->created_at->format('h:i a') }}</span>
                                                        </p>
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                        <p class="last-msg text-gray mb-0">{{ \Illuminate\Support\Str::limit($chat->messages?->last()?->message, 120) }}</p>
                                                        <span class="count">{{ $chat->unReadChatMessagesCount(auth('users')->id()) }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-7">
                        @if($chats->count())
                            @foreach($chats as $chat)
                                <div class="chat-content @if(!$loop->first) d-none  @endif"
                                     id="ChatContent_{{$chat->id}}">
                                    <div class="d-flex align-items-center gap-2 border-bottom content-header">
                                        <div class="img">
                                            <img src="{{ $chat->sender_avatar }}" alt="image">
                                        </div>
                                        <div>
                                            <h6 class="fw-bold mb-0">{{ $chat->sender_name }}</h6>
                                            <p class="status fw-400 text-primary mb-0"><span
                                                        class="dot"></span>{{ trans('web.Online') }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="message-body p-3 border-bottom d-flex flex-column">
                                        @if($chat->messages)
                                            @foreach($chat->messages as $message)
                                                <div class="chat_message @if($message->from_type == \App\Enums\ChatMessageFromTypeEnums::FROM_USER->value && $message->sender_id == auth()->user()->id) sender_msg @else receiver_msg @endif">
                                                    <div class="w-100">
                                                        <div class="content">
                                                            @if($message->offer_id)
                                                                <div class="product">
                                                                    <div class="img mb-2">
                                                                        <img src="{{ $message->offer?->advertisement?->image_path }}"
                                                                             alt="image">
                                                                    </div>
                                                                    <p>{{ \Illuminate\Support\Str::limit($message->offer?->advertisement?->name) }}</p>
                                                                    <div class="d-flex justify-content-between align-items-center gap-2 details mb-2">
                                                                        <p class="fw-400">{{ trans('web.Offer') }}</p>
                                                                        <p class="fw-400">
                                                                            <span class="text-primary fw-600 me-1">{{ $message->offer->offer }}</span>{{ $message->offer?->advertisement?->currency }}
                                                                        </p>
                                                                    </div>

                                                                    <div class="d-flex justify-content-between align-items-center gap-1 btns">

                                                                        @if($message->sender_id != auth()->user()->id && $message->offer->status == \App\Enums\Advertisement\OfferStatusEnums::Pending->value)
                                                                            <a href="{{ route('web.products.updateOffer', ['id' => $message->offer->advertisement_id, 'offerId' => $message->offer->id, 'status' => 'approved']) }}"
                                                                               class="btn btn-gradiant btn-approve w-50">
                                                                                <!--add class="d-none" after approve or reject-->
                                                                                <span class="me-1"><i
                                                                                            class="far fa-circle-check"></i></span>
                                                                                <span>{{ trans('web.Approve') }}</span>
                                                                            </a>

                                                                            <a href="{{ route('web.products.updateOffer', ['id' => $message->offer->advertisement_id, 'offerId' => $message->offer->id, 'status' => 'rejected']) }}"
                                                                               class="btn btn-border btn-reject w-50">
                                                                                <!--add class="d-none" after approve or reject-->
                                                                                <span class="me-1"><i
                                                                                            class="far fa-circle-xmark"></i></span>
                                                                                <span>{{ trans('web.Reject') }}</span>
                                                                            </a>
                                                                        @endif

                                                                        @if($message->offer->status == \App\Enums\Advertisement\OfferStatusEnums::Rejected->value)
                                                                            <a href="#"
                                                                               class="btn btn-border btn-rejected w-100">
                                                                                <span>{{ trans('web.Rejected') }}</span>
                                                                            </a>
                                                                        @endif

                                                                        @if($message->offer->status == \App\Enums\Advertisement\OfferStatusEnums::Approved->value)
                                                                            <a href="#"
                                                                               class="btn btn-border btn-approved w-100">
                                                                                <span>{{ trans('web.approved') }}</span>
                                                                            </a>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            @else
                                                                <p>{{ $message->message }}</p>
                                                            @endif
                                                        </div>
                                                        <div class="date">
                                                            <p class="mb-0">{{ $message->created_at->format('d F Y \A\t g:i A') }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>

                                    <div class="content-footer">
                                        {{ html()->form('post', route('web.chats.send'))->class('d-flex align-items-center')->open() }}
                                        {{ html()->hidden('chat_id', $chat->id)->id($chat->id) }}
                                        <div class="d-flex">
                                            <button type="button" class="btn btn-record start-recording-button">
                                                <i class="fas fa-microphone"></i>
                                            </button>
                                            <div class="recording-contorl-buttons-container hide">
                                                <i class="cancel-recording-button fas fa-times-circle"
                                                   aria-hidden="true"></i>
                                                <div class="recording-elapsed-time">
                                                    <i class="red-recording-dot fas fa-circle"
                                                       aria-hidden="true"></i>
                                                    <p class="elapsed-time"></p>
                                                </div>
                                                <i class="stop-recording-button fas fa-stop-circle"
                                                   aria-hidden="true"></i>
                                            </div>
                                            <audio controls class="audio-element hide"></audio>
                                        </div>
                                        <div class="flex-grow-1 chat-input">
                                            <input type="text" class="form-control py-2" name="message" required
                                                   placeholder="{{ trans('web.Write Something') }} ">
                                        </div>
                                        <button type="submit" class="btn btn-send">
                                            <i class="fas fa-paper-plane"></i>
                                            <span>{{ trans('web.Send') }}</span>
                                        </button>
                                        {{ html()->form()->close() }}
                                    </div>

                                </div>
                            @endforeach
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section("script")
    <script>
        function showChatContent(chatId) {
            $('.user-message').removeClass('active');
            $("#Chat_" + chatId).addClass('active');
            $('.chat-content').addClass('d-none');
            $('#ChatContent_' + chatId).removeClass('d-none');
        }

        // $(document).ready(function () {
        //     $('#filter-search').keyup(function () {
        //         // submit form after press enter
        //         if (event.keyCode === 13) {
        //             $('.filterForm').submit();
        //         }
        //     })
        // })
    </script>
@endsection
