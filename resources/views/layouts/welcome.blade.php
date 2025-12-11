<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  @include('partials.head', ['title' => 'Repair Service'])
</head>
<body class="min-h-screen bg-black text-gray-200">

@include('partials.header')


@include('customer.hero')

 
@include('customer.contact')
@include('partials.support-widget')

  
  @include('partials.footer')
  @stack('scripts')

</body>
</html>
