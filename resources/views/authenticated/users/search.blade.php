@extends('layouts.sidebar')

@section('content')
<div class="search_content w-100 d-flex">
  <!-- ユーザー表示エリア -->
  <div class="reserve_users_area">
    @foreach($users as $user)
    <div class="border one_person">
      <div>
        <span class="name-Icon">ID : </span><span>{{ $user->id }}</span>
      </div>
      <div><span class="name-Icon">名前 : </span>
        <a href="{{ route('user.profile', ['id' => $user->id]) }}">
          <span>{{ $user->over_name }}</span>
          <span>{{ $user->under_name }}</span>
        </a>
      </div>
      <div>
        <span class="name-Icon">カナ : </span>
        <span>({{ $user->over_name_kana }}</span>
        <span>{{ $user->under_name_kana }})</span>
      </div>
      <div>
        @if($user->sex == 1)
        <span class="name-Icon">性別 : </span><span>男</span>
        @elseif($user->sex == 2)
        <span class="name-Icon">性別 : </span><span>女</span>
        @else
        <span class="name-Icon">性別 : </span><span>その他</span>
        @endif
      </div>
      <div>
        <span class="name-Icon">生年月日 : </span><span>{{ $user->birth_day }}</span>
      </div>
      <div>
        @if($user->role == 1)
        <span class="name-Icon">役職 : </span><span>教師(国語)</span>
        @elseif($user->role == 2)
        <span class="name-Icon">役職 : </span><span>教師(数学)</span>
        @elseif($user->role == 3)
        <span class="name-Icon">講師(英語)</span>
        @else
        <span class="name-Icon">役職 : </span><span>生徒</span>
        @endif
      </div>
      <div>
        @if($user->role == 4)
        <span class="name-Icon">選択科目 :</span>
        <ul style="display: inline-block; margin: 0; padding-left: 10px; font-size:12px">
            @foreach($user->subjects as $subject)
                <li style="display: inline; list-style: none; margin-right: 10px;">{{ $subject->subject }}</li>
            @endforeach
        </ul>
        @endif
      </div>
    </div>
    @endforeach

    @if(count($users) % 4 !== 0)
      @for($i = 0; $i < 4 - (count($users) % 4); $i++)
        <div class="empty_cell"></div> <!-- 空のセル -->
      @endfor
    @endif
  </div>

    <!-- 検索エリア -->
  <div class="search_area w-25" style="margin-right: 20px;">
    <!-- 検索タイトル -->
    <div class="search-title py-3">
      <h1 style="color: #002D62; font-size: 20px; margin-right:140px; margin-top:40px;">検索</h1>
    </div>
    <div class="search-list">
      <!-- キーワード検索の入力欄 -->
      <input type="text" class="free_word form-text" name="keyword" placeholder="キーワードを検索"
             form="userSearchRequest" style="border-radius: 5px; border: none; background-color: #E0E2E4; padding: 8px; font-size: 13px;">
    </div>
    <div class="mb-3">
      <!-- カテゴリのタイトル -->
      <label style="color: #002D62; font-size: 14px; margin-left:35px; margin-top:15px;">カテゴリ</label>
    </div>
    <!-- カテゴリ選択の入力欄 -->
    <div class="mb-3">
      <select form="userSearchRequest" name="category" class="form-text"
              style="border-radius: 5px; border: none; background-color: #E0E2E4; padding: 8px; font-size: 13px;">
        <option value="name">名前</option>
        <option value="id">社員ID</option>
      </select>
    </div>
    <!-- 並び替えのタイトル -->
    <div class="mb-3">
      <label style="color: #002D62; font-size: 14px; margin-left:35px;">並び替え</label>
    </div>
    <!-- 並び替え選択の入力欄 -->
    <div class="mb-3">
      <select name="updown" form="userSearchRequest" class="form-text"
              style="border-radius: 5px; border: none; background-color:#d3d3d39c; padding: 8px; font-size: 13px;">
        <option value="ASC">昇順</option>
        <option value="DESC">降順</option>
      </select>
    </div>
  <div class="mb-3">
  <p class="search_conditions" style="color: #002D62; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #002D62; padding-bottom: 5px; cursor: pointer; margin-left: 40px;" onclick="toggleSearchConditions()">
    <span>検索条件の追加</span>
    <span class="arrow arrow-down"></span>
  </p>

  <!-- 検索条件の下に margin-left を追加 -->
  <div id="additionalConditions" style="margin-left: 35px; display: none;">
    <!-- 性別 -->
    <div class="sex-area" style="font-size: 13px; margin-bottom: 10px;">
      <label class="sex-type" style="color: #002D62; font-size: 14px;">性別</label>
      <div style="display: flex; align-items: center; gap: 10px;">
        <span>男</span><input type="radio" name="sex" value="1" form="userSearchRequest">
        <span>女</span><input type="radio" name="sex" value="2" form="userSearchRequest">
        <span>その他</span><input type="radio" name="sex" value="3" form="userSearchRequest">
      </div>
    </div>

    <!-- 権限 -->
    <div class="mb-3" style="font-size: 13px;">
      <label>権限</label>
      <select name="role" form="userSearchRequest" class="form-control"
              style="border-radius: 5px; border: none; background-color: #DDDFE0; padding: 8px; font-size: 13px;">
        <option selected disabled>----</option>
        <option value="1">教師(国語)</option>
        <option value="2">教師(数学)</option>
        <option value="3">教師(英語)</option>
        <option value="4">生徒</option>
      </select>
    </div>

    <!-- 選択科目 -->
    <div class="selected_engineer" style="font-size: 13px;">
      <label>選択科目</label>
      <div>
        @foreach($subjects as $subject)
          <label>
            <input type="checkbox" name="subjects[]" value="{{ $subject->id }}" form="userSearchRequest">
            {{ $subject->subject }}
          </label>
        @endforeach
      </div>
    </div>
  </div>
</div>
    <!-- リセットと検索ボタン -->
    <div class="button-area d-flex flex-column align-items-center">
      <input type="submit" name="search_btn" value="検索" form="userSearchRequest" class="btn btn-primary" style="background-color: #03AAD2; border-color: #17A2B8; width: 180px; margin-bottom: 8px; font-size: 13px;">
      <a href="#" onclick="document.getElementById('userSearchRequest').reset();" class="reset-link" style="color: #007BFF; cursor: pointer; font-size: 13px;">リセット</a>
    </div>
  </div>
  <form action="{{ route('user.show') }}" method="get" id="userSearchRequest"></form>
</div>

<script>
 function toggleSearchConditions() {
  const conditions = document.getElementById('additionalConditions');
  const arrow = document.querySelector('.arrow');  // 矢印の要素を取得

  if (conditions.style.display === 'none' || conditions.style.display === '') {
    conditions.style.display = 'block';  // フォームを表示
    arrow.classList.remove('arrow-down');
    arrow.classList.add('arrow-up');  // 矢印を反転
  } else {
    conditions.style.display = 'none';  // フォームを隠す
    arrow.classList.remove('arrow-up');
    arrow.classList.add('arrow-down');  // 矢印を元に戻す
  }
}
</script>

@endsection
