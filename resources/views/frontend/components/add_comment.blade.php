@auth('users')
    {{--    replay with-form-reply--}}
    <div class="comment">
        <div class="d-flex gap-2 ">
            <div class="img">
                <img src="{{ (auth('users')->user()->image)? auth('users')->user()->image_path : asset('frontend/assets/images/icons/profile-circle.svg') }}"
                     alt="user image">
            </div>
            <div class="user-details flex-grow-1">
                <div class="d-flex justify-content-between">
                    <h6 class="text-dark fw-bold">{{ auth('users')->user()->name }}</h6>
                </div>
                {{ html()->form('post', route('web.comments.add', ['id' => $product_id]))->attribute('id', 'CommentForm')->open() }}
                <input type="hidden" name="product_id" value="{{$product_id}}">
                <input type="hidden" name="parent" value="{{$parent_id}}">
                <textarea name="comment" id="comment_replay" required rows="2" placeholder="{{ trans('web.Comment') }}" class="form-control"
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
    </div>
@else
    <div class="comment">
        <div class="d-flex gap-2 ">
            <div class="img">
                <img src="{{ asset('frontend/assets/images/icons/profile-circle.svg') }}"
                     alt="user image">
            </div>
            <div class="user-details flex-grow-1">
                {{ html()->form('post', route('web.comments.add.guest-user', ['id' => $product_id]))->open() }}
                <textarea name="comment" id="comment_replay" rows="2" placeholder="{{ trans('web.Comment') }}" class="form-control"
                          maxlength="250"></textarea>

                <div class="d-flex gap-2">
                    <button class="btn btn-gradiant btn-send-replay py-1 px-4 mt-2">{{ trans('web.Send') }}</button>
                    <a href="javascript:void(0);" class="btn btn-border btn-cancel-replay py-1 px-4 mt-2">{{ trans('web.Cancel') }}</a>
                </div>
                {{ html()->form()->close() }}
            </div>
        </div>
    </div>
@endauth