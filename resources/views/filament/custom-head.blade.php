{{-- Custom head for Filament --}}
{{-- This prevents "View [filament.custom-head] not found" errors if referenced anywhere. --}}
<meta name="csrf-token" content="{{ csrf_token() }}">
{{-- Place any extra <head> tags specific to Filament here. --}}
