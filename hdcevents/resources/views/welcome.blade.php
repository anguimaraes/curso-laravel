@extends('layouts.main')

@section('title', 'HDC Events')

@section('content')

<h1>Titulo Teste</h1>
<img src="/img/banner.jpg" alt="Banner">

<p>{{$nome}}</p>

@if($nome == "Pedro")
<p>O nome é Pedro</p>
@elseif($nome == "André")
<p>O nome é {{$nome}} e ele tem {{$idade}} anos.</p>
@else
<p>O nome não é Pedro</p>
@endif

@for($i = 0; $i < count($arr); $i++) <p>{{$arr[$i]}}</p>
    @endfor

    @foreach($nomes as $nome)
    <p>{{ $nome }}</p>
    @endforeach

    @php
    $name = "ManoloDerpina";
    //echo $name;
    @endphp

    {{-- Este é o comentario do blade --}}

    @endsection