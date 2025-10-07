@extends( config('account.app_layout') )
@section( config('account.app_section') )
<link rel="stylesheet" type="text/css" href="{{ asset('/modules/account/css/account.css') }}">
<?php $sub_menu = $sub_menu ?? 'home'; ?>
<div class="col-sm-4 col-md-3">
	<div class="list-group">
    	<a href="{{ route('account.home') }}" class="list-group-item {{ $sub_menu == 'home' ? 'active' :'' }}">Acceuil</a>
    	<a href="{{ route('account.groups.index') }}" class="list-group-item {{ $sub_menu =='groups' ? 'active' :'' }}">Groupes</a>
    	<a href="#" class="list-group-item {{ $sub_menu =='user-permissions' ? 'active' :'' }}">Permissions</a>
    </div>
</div>
<div class="col-sm-8 col-md-9" style="min-height: 560px;">
    @yield('account')
</div>
<script type="text/javascript" src="{{ asset('/modules/account/js/account.js') }}"></script>
@endsection