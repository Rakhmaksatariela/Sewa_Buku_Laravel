@if (Session::has('flash_message'))
    <div class="alert alert-success {{ Session::has('penting')? 'alert-important' : '' }}">
        {{ Session::get('flash_message') }}
    </div>
@elseif (Session::has('flash_message2'))
    <div class="alert alert-danger {{ Session::has('penting')? 'alert-important' : '' }}">
        {{ Session::get('flash_message2') }}
    </div>
@endif

