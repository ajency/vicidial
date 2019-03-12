<meta charset="utf-8">
<base href="/">
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700" rel="stylesheet">
<meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0 shrink-to-fit=no'/>
<meta name="csrf-token" content="{{ csrf_token() }}">
<link  rel="icon" type="image/x-icon" href="{{CDN::asset('/img/fav/fav-64.png') }}" />
<link rel="manifest" href="manifest.json">
<meta name="theme-color" content="#707279"/>
<link rel="stylesheet" href="views/kss-pwa/styles.css">
{!! SEOMeta::generate() !!}
{!! OpenGraph::generate() !!}
{!! Twitter::generate() !!}