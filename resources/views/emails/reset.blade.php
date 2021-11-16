@extends('beautymail::templates.sunny')

@section('content')

    @include ('beautymail::templates.sunny.heading' , [
        'heading' => __('subject.password_reset'),
        'level' => 'h1',
    ])

    @include('beautymail::templates.sunny.contentStart')

    <p>{{ __('messages.email_reset') }}</p>

    @include('beautymail::templates.sunny.contentEnd')

    @include('beautymail::templates.sunny.button', [
        	'title' => __('messages.recover'),
        	'link' => url('/set-password/' . $user->token_recuperacion)
    ])

@stop
