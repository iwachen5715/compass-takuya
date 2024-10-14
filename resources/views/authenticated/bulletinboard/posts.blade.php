@extends('layouts.sidebar')

@section('content')
<div class="board_area w-100 border m-auto d-flex top-view">
  <div class="post_view w-75 mt-5">
    <p class="w-75 m-auto"></p>
    @foreach($posts as $post)
    <div class="post_area border w-75 m-auto p-3">
      <p class="post-flex"><span>{{ $post->user->over_name }}</span><span class="ml-3">{{ $post->user->under_name }}</span>さん</p>
      <p><a class="post-name" href="{{ route('post.detail', ['id' => $post->id]) }}">{{ $post->post_title }}</a></p>
      <!-- サブカテゴリー表示部分 -->
      <div class="sub_category_display mt-3">
        @foreach($post->subCategories as $subCategory)
          <span class="sub_category_label">{{ $subCategory->sub_category }}</span>
        @endforeach
      </div>
      <div class="post_bottom_area d-flex">
        <div class="d-flex post_status">
          <div class="mr-5">
            <i class="fa fa-comment"></i><span class="">{{ $post->postComments->count() }}</span>
          </div>
          <div>
            @if(Auth::user()->is_Like($post->id))
            <p class="m-0"><i class="fas fa-heart un_like_btn" post_id="{{ $post->id }}"></i><span class="like_counts{{ $post->id }}">{{ $post->likeCounts($post->id) }}</span></p>
            @else
            <p class="m-0"><i class="fas fa-heart like_btn" post_id="{{ $post->id }}"></i><span class="like_counts{{ $post->id }}">{{ $post->likeCounts($post->id) }}</span></p>
            @endif
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>
  <div class="other_area w-25">
    <div class=" m-4">
     <div class="post-buttom">
  <a href="{{ route('post.input') }}" class="custom-btn">投稿</a>
     </div>
  <div class="search-container">
     <input type="text" placeholder="キーワードを検索" name="keyword" form="postSearchRequest">
    <input type="submit" value="検索" form="postSearchRequest">
    </div>
    <div class="button-container">
  <input type="submit" name="like_posts" class="category_btn like_posts_btn" value="いいねした投稿" form="postSearchRequest">
  <input type="submit" name="my_posts" class="category_btn my_posts_btn" value="自分の投稿" form="postSearchRequest">
    </div>
  <h2 class="text-search">カテゴリー検索</h2>
<!-- カテゴリーリスト -->
<div class="w-100 m-auto">
  <ul style="list-style: none; padding: 0;">
    @foreach($categories as $category)
    <li class="main_categories" category_id="{{ $category->id }}" style="cursor: pointer; margin-bottom: 10px;">
      <div class="category-header" style="display: flex; justify-content: space-between; align-items: center;">
        <!-- メインカテゴリー名を左詰め -->
        <div style="width: 100%; border-bottom: 1px solid #9E9EA1; text-align: left; padding-bottom: 5px;">
          <span style="padding-left: 0;">{{ $category->main_category }}</span>
          <!-- <span class="arrow" style=" margin-left: 10px;"></span> 上向き矢印 -->
        </div>
      </div>
     <ul class="sub_categories" style="display: none; padding-left: 20px; margin:10px">
  @foreach($category->subCategories as $subCategory)
    <li class="sub_category_item">
      <a href="#" class="sub_category_link" data-category="{{ $subCategory->sub_category }}">
        {{ $subCategory->sub_category }}
      </a>
    </li>
  @endforeach
</ul>
    </li>
    @endforeach
  </ul>
</div>
    <!-- サーチ用の隠しフォーム -->
    <form action="{{ route('post.show') }}" method="get" id="postSearchRequest">
      <input type="hidden" name="category_word" id="category_word">
    </form>
  </div>
</div>
<!-- jQuery を使ったスライド表示と矢印の切り替えスクリプト -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
 <script>
  $(document).ready(function() {
    // メインカテゴリーをクリックしたらサブカテゴリーがスライドして表示され、矢印が切り替わる
    $('.main_categories').click(function() {
      // サブカテゴリーをスライド表示/非表示
      $(this).find('.sub_categories').slideToggle();

      // 矢印の向きを切り替えるクラス 'open' をトグルする
      $(this).toggleClass('open');
    });

    // サブカテゴリーをクリックしたら、フォームに値を入れて送信する
    $('.sub_category_link').click(function(e) {
      e.preventDefault();
      var subCategory = $(this).data('category');
      $('#category_word').val(subCategory); // フォームにサブカテゴリーの値をセット
      $('#postSearchRequest').submit(); // フォームを送信
    });
  });
  </script>


@endsection
