@if (request()->input('media-action') === 'select-files')
    <html>
        <head>
            <meta name="csrf-token" content="{{ csrf_token() }}">
            {!! Assets::renderHeader() !!}
            {!! LouisMedia::renderHeader() !!}
        </head>
        <body>
            {!! LouisMedia::renderContent() !!}
            {!! Assets::renderFooter() !!}
            {!! LouisMedia::renderFooter() !!}
        </body>
    </html>
@else
    {!! LouisMedia::renderHeader() !!}

    {!! LouisMedia::renderContent() !!}

    {!! LouisMedia::renderFooter() !!}
@endif
