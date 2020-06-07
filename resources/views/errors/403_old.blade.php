@extends('errors.error')

@section('code', 403)
@section('title', 'ДОСТУП ОГРАНИЧЕН')
@section('message', $exception->getMessage() ?? 'Доступ к данной странице ограничен.')
