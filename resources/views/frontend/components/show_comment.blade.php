<div class="comment {{ $commentClass }}" data-id="{{ $comment->id }}">
    <div class="d-flex gap-2 ">
        <div class="img">
            <img src="{{ ($comment->user && $comment->user->image_path) ? $comment->user->image_path : asset('frontend/assets/images/icons/profile-circle.svg') }}"
                 alt="user image">
        </div>
        <div class="user-details flex-grow-1">
            <div class="d-flex justify-content-between">
                <h6 class="text-dark fw-bold">{{ $comment->user?->name }}</h6>
                @if(auth('users')->check() && auth('users')->user()->id != $comment->user_id)
                    <div class="options">
                        <div class="option"><i class="fas fa-ellipsis-vertical"></i></div>
                        <div class="list">
                            <div class="arrow"></div>
                            <ul>
                                @if($comment->is_following)
                                    <li class="following">
                                        <a href="{{ route('web.comments.unFollow', ['id'=>$comment->advertisement_id, 'commentId'=>$comment->id]) }}"
                                           class="text-success">
                                            <i class="far fa-circle-check"></i>
                                            <span class="ms-1">{{ trans('web.Following') }}</span>
                                        </a>
                                    </li>
                                @else
                                    <li class="follow-comment">
                                        <a href="{{ route('web.comments.follow', ['id'=>$comment->advertisement_id, 'commentId'=>$comment->id]) }}">
                                            <i class="far fa-message"></i>
                                            <span class="ms-1">{{ trans('web.Follow Comment') }}</span>
                                        </a>
                                    </li>
                                @endif
                                <li class="report">
                                    <a href="javascript:void(0);" data-bs-toggle="modal"
                                       data-bs-target="#commentReportModal-{{$comment->id}}">
                                        <i class="far fa-flag"></i>
                                        <span class="ms-1">{{ trans('web.Report') }}</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                @endif
            </div>
            <div class="msg-content mb-2" id="msgText-{{$comment->id}}"> {{ $comment->comment }}</div>
            <div class="d-flex flex-wrap align-items-center gap-2">
                <p class="text-gray date mb-0">{{ $comment->created_at->format('d F Y \A\t g:i A') }}</p>

                @if($canReply)
                    <a href="javascript:void(0)" class="btn-replay me-2" data-id="{{ $comment->id }}"
                       data-product="{{ $comment->advertisement_id }}"><span class="me-1"><i
                                class="far fa-message"></i></span><span>{{ trans('web.Reply') }}</span></a>
                @endif

                @if(auth('users')->check() && auth('users')->user()->id == $comment->user_id)
                    <a href="javascript:void(0)" class="btn-edit me-2" data-id="{{ $comment->id }}"><span
                            class="me-1"><i
                                class="far fa-pen-to-square"></i></span><span>{{ trans('web.Edit') }}</span></a>

                    <a href="javascript:void(0)" class="btn-delete me-2 text-red" data-id="{{ $comment->id }}">
                        <span class="me-1">
                            <i class="far fa-trash-can"></i></span>
                        <span>{{ trans('web.Delete') }}</span>
                    </a>
                @endif

            </div>
        </div>
    </div>
    @if($comment->child)
        @foreach($comment->child as $child)
            @include('frontend.components.show_comment', ['comment' => $child, 'commentClass' => 'replay', 'canReply' => false])
            @include('frontend.components.report_comment', ['product_id' => $comment->advertisement_id, 'commentId' => $child->id])
        @endforeach
    @endif
</div>

@include('frontend.components.report_comment', ['product_id' => $comment->advertisement_id, 'commentId' => $comment->id])
