@extends('layouts.app')

@section('head')
    <title>{{ ucfirst($subject) }} {{ $year }} | Maturitné testy</title>
@stop

@section('content')
    <livewire:quiz :subject="$subject" :year="$year"/>
@stop
