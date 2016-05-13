@extends('beautymail::templates.sunny')

@section('content')

    @include ('beautymail::templates.sunny.heading' , [
        'heading' => 'Welcome to new here!',
        'level' => 'h1',
    ])

    @include ('beautymail::templates.sunny.heading' , [
        'heading' => 'Thank you for your registration!',
        'level' => 'h2',
    ])
    @include('beautymail::templates.sunny.contentStart')

        <p>We have just received an user registration for this email. To active this account you just have click the button below and you can immediately start over.</p>

    @include('beautymail::templates.sunny.contentEnd')

    @include('beautymail::templates.sunny.button', [
            'title' => 'Confirm my account',
            'link' => url('/api/auth/confirmation/'.$confirmation_code),
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
