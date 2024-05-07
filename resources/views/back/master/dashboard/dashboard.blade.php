@extends('back.layouts.main')

@section('content')
    <form action="{{ route('logout') }}" method="POST">
    @csrf
    <button class="btn btn-primary w-full" type="submit">Logout</button>
    </form>
@endsection