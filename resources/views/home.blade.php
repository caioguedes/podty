@extends('layouts.app')
@section('title', 'Vllep')

@section('content')
    <section class="vbox">
          @include('header')
        <section>
          <section class="hbox stretch">
          @if(Auth::guest())
              <div style="height: 100%;/* overflow-y: scroll;*/">
                @include('home.guest')
              </div>
          @else
              @include('home.logged')
          @endif
          </section>
        </section>
    </section>
@endsection
