@extends('layouts.sidebar')

@section('content')
<div class="vh-100 position-relative">
  <div class="top_area w-75 position-absolute" style="top: 0; left: 0;">
    <!-- ユーザー名を左上に配置 -->
    <span>{{ $user->over_name }}</span><span>{{ $user->under_name }}さんのプロフィール</span>

    <div class="user_status p-3 mt-5">
      <p>名前 : <span>{{ $user->over_name }}</span><span class="ml-1">{{ $user->under_name }}</span></p>
      <p>カナ : <span>{{ $user->over_name_kana }}</span><span class="ml-1">{{ $user->under_name_kana }}</span></p>
      <p>性別 : @if($user->sex == 1)<span>男</span>@else<span>女</span>@endif</p>
      <p>生年月日 : <span>{{ $user->birth_day }}</span></p>

      <div>選択科目 :
        @foreach($user->subjects as $subject)
          <span>{{ $subject->subject }}</span>
        @endforeach
      </div>


        @can('admin')
        <span class="subject_edit_btn ">選択科目の登録</span>
        <div class="subject_inner mt-3">
          <form action="{{ route('user.edit') }}" method="post">
            <div class="d-flex justify-content-start top-list">
              @foreach($subject_lists as $subject_list)
              <div class="mr-4">
                <label>{{ $subject_list->subject }}</label>
                <input type="checkbox" name="subjects[]" value="{{ $subject_list->id }}">
              </div>
              @endforeach
              <!-- 登録ボタン -->
              <input type="submit" value="登録" class="btn btn-primary register-confirm">
            </div>
            <input type="hidden" name="user_id" value="{{ $user->id }}">
            {{ csrf_field() }}
          </form>
        </div>
        @endcan
      </div>
    </div>
  </div>
</div>


@endsection
