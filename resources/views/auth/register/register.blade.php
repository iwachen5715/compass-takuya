<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AtlasBulletinBoard</title>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
  <link href="{{ asset('css/style.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300&family=Oswald:wght@200&display=swap" rel="stylesheet">
  <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
</head>
<body>
  <form action="{{ route('registerPost') }}" method="POST">
    @csrf
    <div class="w-100 vh-100 d-flex" style="align-items:center; justify-content:center;">
      <div class="w-25 vh-75 border p-3">


<!-- エラーメッセージの表示 -->


<div class="register_form">
  <div class="d-flex mt-3" style="justify-content:space-between">
    <div class="" style="width:140px">
      @if ($errors->has('over_name'))
        <div class="text-danger" style="font-size:12px">{{ $errors->first('over_name') }}</div>
      @endif
      <label class="d-block m-0" style="font-size:13px">姓</label>
      <div class="border-bottom border-primary" style="width:140px;">
        <input type="text" style="width:140px;" class="border-0 over_name" name="over_name" value="{{ old('over_name') }}">
      </div>
    </div>
    <div class="" style="width:140px">
      @if ($errors->has('under_name'))
        <div class="text-danger" style="font-size:12px">{{ $errors->first('under_name') }}</div>
      @endif
      <label class="d-block m-0" style="font-size:13px">名</label>
      <div class="border-bottom border-primary" style="width:140px;">
        <input type="text" style="width:140px;" class="border-0 under_name" name="under_name" value="{{ old('under_name') }}">
      </div>
    </div>
  </div>
  <div class="d-flex mt-3" style="justify-content:space-between">
    <div class="" style="width:140px">
      @if ($errors->has('over_name_kana'))
        <div class="text-danger" style="font-size:12px">{{ $errors->first('over_name_kana') }}</div>
      @endif
      <label class="d-block m-0" style="font-size:13px">セイ</label>
      <div class="border-bottom border-primary" style="width:140px;">
        <input type="text" style="width:140px;" class="border-0 over_name_kana" name="over_name_kana" value="{{ old('over_name_kana') }}">
      </div>
    </div>
    <div class="" style="width:140px">
      @if ($errors->has('under_name_kana'))
        <div class="text-danger" style="font-size:12px">{{ $errors->first('under_name_kana') }}</div>
      @endif
      <label class="d-block m-0" style="font-size:13px">メイ</label>
      <div class="border-bottom border-primary" style="width:140px;">
        <input type="text" style="width:140px;" class="border-0 under_name_kana" name="under_name_kana" value="{{ old('under_name_kana') }}">
      </div>
    </div>
  </div>
  <div class="mt-3">
    @if ($errors->has('mail_address'))
      <div class="text-danger" style="font-size:12px">{{ $errors->first('mail_address') }}</div>
    @endif
    <label class="m-0 d-block" style="font-size:13px">メールアドレス</label>
    <div class="border-bottom border-primary">
      <input type="email" class="w-100 border-0 mail_address" name="mail_address" value="{{ old('mail_address') }}">
    </div>
  </div>
</div>
<div class="mt-3">
  @if ($errors->has('sex'))
    <div class="text-danger" style="font-size:12px">{{ $errors->first('sex') }}</div>
  @endif
  <input type="radio" name="sex" class="sex" value="1" {{ old('sex') == '1' ? 'checked' : '' }}>
  <label style="font-size:13px">男性</label>
  <input type="radio" name="sex" class="sex" value="2" {{ old('sex') == '2' ? 'checked' : '' }}>
  <label style="font-size:13px">女性</label>
  <input type="radio" name="sex" class="sex" value="3" {{ old('sex') == '3' ? 'checked' : '' }}>
  <label style="font-size:13px">その他</label>
</div>
<div class="mt-3">
  @if ($errors->has('old_year') || $errors->has('old_month') || $errors->has('old_day'))
    <div class="text-danger" style="font-size:12px">{{ $errors->first('old_year') ?: ($errors->first('old_month') ?: $errors->first('old_day')) }}</div>
  @endif
  <label class="d-block m-0 aa" style="font-size:13px">生年月日</label>
  <select class="old_year" name="old_year">
    <option value="none">-----</option>
     @for ($year = 1985; $year <= 2010; $year++)
    <option value="{{ $year }}" {{ old('old_year') == $year ? 'selected' : '' }}>{{ $year }}</option>
@endfor

  </select>
  <label style="font-size:13px">年</label>
  <select class="old_month" name="old_month">
    <option value="none">-----</option>
    @for ($month = 1; $month <= 12; $month++)
      <option value="{{ sprintf('%02d', $month) }}" {{ old('old_month') == sprintf('%02d', $month) ? 'selected' : '' }}>{{ $month }}</option>
    @endfor
  </select>
  <label style="font-size:13px">月</label>
  <select class="old_day" name="old_day">
    <option value="none">-----</option>
    @for ($day = 1; $day <= 31; $day++)
      <option value="{{ sprintf('%02d', $day) }}" {{ old('old_day') == sprintf('%02d', $day) ? 'selected' : '' }}>{{ $day }}</option>
    @endfor
  </select>
  <label style="font-size:13px">日</label>
</div>
<div class="mt-3">
  @if ($errors->has('role'))
    <div class="text-danger" style="font-size:12px">{{ $errors->first('role') }}</div>
  @endif
  <label class="d-block m-0" style="font-size:13px">役職</label>
  <input type="radio" name="role" class="admin_role role" value="1" {{ old('role') == '1' ? 'checked' : '' }}>
  <label style="font-size:13px">教師(国語)</label>
  <input type="radio" name="role" class="admin_role role" value="2" {{ old('role') == '2' ? 'checked' : '' }}>
  <label style="font-size:13px">教師(数学)</label>
  <input type="radio" name="role" class="admin_role role" value="3" {{ old('role') == '3' ? 'checked' : '' }}>
  <label style="font-size:13px">教師(英語)</label>
  <input type="radio" name="role" class="other_role role" value="4" {{ old('role') == '4' ? 'checked' : '' }}>
  <label style="font-size:13px" class="other_role">生徒</label>
</div>
<div class="select_teacher d-none">
  @if ($errors->has('subject'))
    <div class="text-danger" style="font-size:12px">{{ $errors->first('subject') }}</div>
  @endif
  <label class="d-block m-0" style="font-size:13px">選択科目</label>
  @foreach($subjects as $subject)
  <div class="">
    <input type="checkbox" name="subject[]" value="{{ $subject->id }}" {{ in_array($subject->id, old('subject', [])) ? 'checked' : '' }}>
    <label>{{ $subject->subject }}</label>
  </div>
  @endforeach
</div>
<div class="mt-3">
  @if ($errors->has('password'))
    <div class="text-danger" style="font-size:12px">{{ $errors->first('password') }}</div>
  @endif
  <label class="d-block m-0" style="font-size:13px">パスワード</label>
  <div class="border-bottom border-primary">
    <input type="password" class="border-0 w-100 password" name="password">
  </div>
</div>
<div class="mt-3">
  @if ($errors->has('password_confirmation'))
    <div class="text-danger" style="font-size:12px">{{ $errors->first('password_confirmation') }}</div>
  @endif
  <label class="d-block m-0" style="font-size:13px">確認用パスワード</label>
  <div class="border-bottom border-primary">
    <input type="password" class="border-0 w-100 password_confirmation" name="password_confirmation">
  </div>
</div>

        <div class="mt-5 text-right">
          <input type="submit" class="btn btn-primary register_btn" disabled value="新規登録" onclick="return confirm('登録してよろしいですか？')">
        </div>
        <div class="text-center">
          <a href="{{ route('loginView') }}">ログインはこちら</a>
        </div>
      </div>

    </div>
  </form>
  </div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script src="{{ asset('js/register.js') }}" rel="stylesheet"></script>
</body>
</html>
