@if(session('success'))
    <x-alert type="success" icon="fas fa-check-circle">
        {{ session('success') }}
    </x-alert>
@endif

@if(session('error'))
    <x-alert type="danger" icon="fas fa-exclamation-circle">
        {{ session('error') }}
    </x-alert>
@endif

@if(session('warning'))
    <x-alert type="warning" icon="fas fa-exclamation-triangle">
        {{ session('warning') }}
    </x-alert>
@endif

@if(session('info'))
    <x-alert type="info" icon="fas fa-info-circle">
        {{ session('info') }}
    </x-alert>
@endif

@if($errors->any())
    <x-alert type="danger" icon="fas fa-exclamation-circle">
        <strong>{{ __('Please fix the following errors:') }}</strong>
        <ul class="mb-0 mt-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </x-alert>
@endif
