@extends('layouts.sidebar')

@section('content')
<div class="vh-100 d-flex">

  <!-- 投稿詳細とコメント一覧 -->
  <div class="w-50 mt-5">
    <div class="m-3 detail_container">

      <div class="p-3">
        <!-- エラーメッセージ表示 -->
        @if ($errors->has('post_title') || $errors->has('post_body'))
          <div class="alert alert-time">
              <ul>
                  @if ($errors->has('post_title'))
                      <li>{{ $errors->first('post_title') }}</li>
                  @endif
                  @if ($errors->has('post_body'))
                      <li>{{ $errors->first('post_body') }}</li>
                  @endif
              </ul>
          </div>
        @endif

        <div class="detail_inner_head">
          <div>
            <!-- サブカテゴリー表示部分 -->
            <div class="sub_category_display">
              @foreach($post->subCategories as $subCategory)
                <span class="sub_category_label">{{ $subCategory->sub_category }}</span>
              @endforeach
            </div>
          </div>
          <div>
            @if(Auth::id() == $post->user_id)
              <span class="btn btn-primary edit-modal-open"
                    post_title="{{ $post->post_title }}"
                    post_body="{{ $post->post }}"
                    post_id="{{ $post->id }}">編集</span>
              <form action="{{ route('post.delete', ['id' => $post->id]) }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-danger" onclick="return confirm('本当に削除しますか？')">削除</button>
              </form>
            @endif
          </div>
        </div>

        <!-- 投稿者情報 -->
        <div class="contributor">
          <p class="font-form">
            <span>{{ $post->user->over_name }}</span>
            <span>{{ $post->user->under_name }}</span>さん
          </p>
          <span class="ml-5">{{ $post->created_at }}</span>
        </div>

        <!-- 投稿タイトルと内容 -->
        <div class="detsail_post_title">{{ $post->post_title }}</div>
        <div class="mt-3 detsail_post">{{ $post->post }}</div>

        <!-- コメント表示部分 -->
        <div class="p-3">
          <div class="comment_container">
            <span class="">コメント</span>
            @foreach($post->postComments as $comment)
            <div class="comment_area border-top">
              <p>
                <span>{{ $comment->commentUser($comment->user_id)->over_name }}</span>
                <span>{{ $comment->commentUser($comment->user_id)->under_name }}</span>さん
              </p>
              <p>{{ $comment->comment }}</p>
            </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- コメント投稿部分 -->
  <div class="w-50 p-3">
    <div class="comment_container border m-5">
      <div class="comment_area p-3">
        <!-- エラーメッセージの表示 -->
        @if ($errors->has('comment'))
          <div class="alert alert-time">
              <ul>
                  @foreach ($errors->get('comment') as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
        @endif
        <p class="m-0">コメントする</p>
        <form action="{{ route('comment.create') }}" method="post" id="commentRequest">
          {{ csrf_field() }}
          <textarea class="w-100" name="comment"></textarea>
          <input type="hidden" name="post_id" value="{{ $post->id }}">
          <input type="submit" class="btn btn-primary" value="投稿">
        </form>
      </div>
    </div>
  </div>
</div>

<!-- 削除確認モーダル -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">削除確認</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        この投稿を削除してもよろしいですか？
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
        <button type="button" class="btn btn-danger" onclick="document.getElementById('deleteForm').submit()">削除</button>
      </div>
    </div>
  </div>
</div>

<!-- 編集モーダル -->
<div class="modal js-modal">
  <div class="modal__bg js-modal-close"></div>
  <div class="modal__content">
    <form action="{{ route('post.edit') }}" method="post">
      <div class="w-100">
        <div class="modal-inner-title w-50 m-auto">
          <input type="text" name="post_title" placeholder="タイトル" class="w-100">
        </div>
        <div class="modal-inner-body w-50 m-auto pt-3 pb-3">
          <textarea placeholder="投稿内容" name="post_body" class="w-100"></textarea>
        </div>
        <div class="w-50 m-auto edit-modal-btn exit-btn">
          <a class="js-modal-close btn btn-danger d-inline-block " href="">閉じる</a>
          <input type="hidden" class="edit-modal-hidden" name="post_id" value="">
          <input type="submit" class="btn btn-primary d-block" value="編集">
        </div>
      </div>
      {{ csrf_field() }}
    </form>
  </div>
</div>

@endsection

<!-- CSSスタイルの追加 -->
<style>
  .sub_category_label {
    display: inline-block;
    background-color: #add8e6; /* 水色 */
    color: white;
    border-radius: 50px; /* 丸いバッジ */
    padding: 5px 10px;
    margin-right: 5px;
    font-size: 12px;
  }
</style>
