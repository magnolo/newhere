@extends('beautymail::templates.sunny')

@section('content')

    @include ('beautymail::templates.sunny.heading' , [
        'heading' => 'Reset your password!',
        'level' => 'h1',
    ])

    @include('beautymail::templates.sunny.contentStart')

        <p>To set a new password for your account, click the link below</p>

    @include('beautymail::templates.sunny.contentEnd')

    @include('beautymail::templates.sunny.button', [
            'title' => 'Set a new password',
            'link' => url('/#/reset-password/'.$token),
            'color' => '#357DBA'
    ])


@stop

@section('footer')
<p>Nähere Informationen und Rückfragen unter:<br>
E-Mail: <a href="mailto:info@newhere.at">info@newhere.at</a></p>
<p>
© 2016 New Here
</p>
@stop
