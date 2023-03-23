<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets_for_adminwrap/images/favicon.png') }}">
    <title>{{ $page_data->title }}</title>
    <link rel="stylesheet" href="{{ asset('build/header_css/'.$site->header.'/header.css') }}">
    <link rel="stylesheet" href="{{ asset('build/footer_css/'.$site->footer.'/footer.css') }}">

    <!-- modules -->
    @if(!empty($page_data->page_modules))
    @foreach($page_data->page_modules as $modules)
    @if (preg_match("/popup/", $modules))
    <link rel="stylesheet" href="{{ asset('build/Modules_css/popup/'.$modules.'.css') }}">
    @else
    <link rel="stylesheet" href="{{ asset('build/Modules_css/'.$page_data->page_for.'/'.$page_data->page_template.'/'.$modules.'.css') }}">
    @endif
    @endforeach
    @endif
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  </head>
  <body id="page-top">
  @include("web.templates.headers.".$site->header)
  @yield('newcontent')
  @include("web.templates.footers.".$site->footer)
  <script src="{{ asset('js/web/webjs.js') }}"></script>
   <script>
    ajaxhandler="{{ route('web_ajaxhandler') }}";
  </script>
  </body>
</html>