@extends('layouts.app')

@section('content')
    @auth
        <form action="{{ route('logOut') }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit">Logout</button>
        </form>
    @endauth
@endsection
