@foreach($comments as $comment)
    @include('frontend.components.show_comment', ['comment' => $comment, 'commentClass' => 'comment-list border-bottom', 'canReply' => true])
@endforeach
