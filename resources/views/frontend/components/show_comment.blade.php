<div class="comment {{ $commentClass }} ">
    <!-- add class="comment-list" if has replay comments-->
    <div class="d-flex gap-2 ">
        <div class="img">
            <img src="{{ ($comment->user && $comment->user->image_path) ? $comment->user->image_path: asset('frontend/assets/images/icons/profile-circle.svg') }}"
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

                    <a href="{{ route('web.comments.delete', ['id' => $comment->advertisement_id, 'commentId' => $comment->id]) }}"
                       class="btn-delete me-2 text-red">
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

@section("script")

    <script>
        $(document).ready(function () {
            $('#comment_replay').keypress(function (e) {
                if (e.which == 13) {
                    $('#CommentForm').submit();
                    return false;
                }
            });

            $('.comment .btn-replay').click(function () {
                @auth('users')
                $(this).off('click').addClass('disabled').attr('href', 'javascript:void(0)');
                var commentId = $(this).data('id');
                $(this).closest('.comment').addClass('add-replay');
                $(this).closest('.comment').append(`
                                <div class="comment replay with-form-reply">
                                    <div class="d-flex gap-2 ">
                                        <div class="img">
                                            <img src="{{ (auth('users')->user()->image)? auth('users')->user()->image_path : asset('frontend/assets/images/icons/profile-circle.svg') }}"
                                                 alt="user image">
                                        </div>
                                        <div class="user-details flex-grow-1">
                                            <div class="d-flex justify-content-between">
                                                <h6 class="text-dark fw-bold">{{ auth('users')->user()->name }}</h6>
                                            </div>
                                            {{ html()->form('post', route('web.comments.add', ['id' => $comment->advertisement_id]))->attribute('id', 'CommentForm')->open() }}
                {{ html()->hidden('product_id', $comment->advertisement_id) }}
                <input type="hidden" name="parent" value="${commentId}">
                                                                <textarea name="comment" id="comment_replay" required rows="2" placeholder="{{ trans('web.Replay') }}" class="form-control"
                                                                          maxlength="250"></textarea>
                                                                @if($errors->product_comment->has("comment"))
                <div class="error-note">
                    <span class="help-block text-danger">{{ $errors->product_comment->first("comment") }}</span>
                                                                    </div>
                                                                @endif
                <div class="d-flex gap-2">
                    <button class="btn btn-gradiant btn-send-replay py-1 px-4 mt-2">{{ trans('web.Send') }}</button>
                                    <a href="javascript:void(0);" class="btn btn-border btn-cancel-replay py-1 px-4 mt-2">{{ trans('web.Cancel') }}</a>
                                </div>
                            {{ html()->form()->close() }}
                </div>
            </div>
        </div>`);
                @endauth

                replayBtnsTrigger();
            })

            $('.comment .btn-cancel-replay').click(function () {
                $("#comment_replay").val('');
            })

            $('.comment .btn-edit').click(function () {
                var commentId = $(this).data('id');
                var action = "{{ url('/products/'.$comment->advertisement_id.'/comments/') }}/" + commentId;
                $(this).off('click').addClass('disabled').attr('href', 'javascript:void(0)');
                $(this).closest('.comment').addClass('edit-comment');
                $(this).closest('.user-details').find('.msg-content').addClass('d-none');
                $(this).closest('.comment-btns').addClass('d-none');
                $(this).closest('.user-details').append(`
                <form class="edit-form" action="${action}" method="post">
                    {{ csrf_field() }}
                <textarea name="comment" id="comment_replay" rows="2" placeholder="Replay" class="form-control" maxlength="250"></textarea>
                <div class="d-flex gap-2">
                    <button class="btn btn-gradiant btn-edit-comment py-1 px-4 mt-2" type="submit">{{ trans('web.Send') }}</button>
                        <a href="javascript:void(0);" class="btn btn-border btn-cancel-form py-1 px-4 mt-2">{{ trans('web.Cancel') }}</a>
                    </div>
                    {{ html()->form()->close() }}
                `);
                let commentTxt = $(this).closest('.edit-comment').find('#msgText-' + commentId + '').text();
                $(this).closest('.user-details').find('#comment_replay').val(commentTxt).focus();

                editBtnsTrigger();
            })

            function replayBtnsTrigger() {
                $('.comment .with-form-reply .btn-cancel-replay').unbind('click');
                $('.comment .with-form-reply .btn-cancel-replay').click(function () {
                    $(this).closest('.add-replay').find('.with-form-reply').remove();
                    $(this).closest('.comment').removeClass('add-replay');
                })
            }

            function editBtnsTrigger() {
                $('.edit-form .btn-cancel-form').unbind('click');
                $('.edit-form .btn-cancel-form').click(function () {
                    $(this).closest('.user-details').find('.msg-content').removeClass('d-none');
                    $(this).closest('.user-details').find('.comment-btns').removeClass('d-none');
                    $(this).closest('.comment').removeClass('edit-comment');
                    $(this).closest('.edit-form').remove();
                })
            }
        });
    </script>
@endsection
