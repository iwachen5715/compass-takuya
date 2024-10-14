@extends('layouts.sidebar')

@section('content')
<div class="pt-5" style="background:#ECF1F6;">
  <div class="border w-75 m-auto pt-5 pb-5" style="border-radius:5px; background:#FFF;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); border-radius:10px;">
    <div class="w-75 m-auto">
  <div class="w-100 text-center">
    <p>{{ $calendar->getTitle() }}</p>
    <p>{!! $calendar->render() !!}</p>
  </div>
</div>

@endsection
