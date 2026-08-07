<x-layouts.frontend-layout :title="$metaTitle ?? config('app.name')" :seoData="$seoData ?? []" :metaDescription="$metaDescription ?? ''">
    {{ $slot }}
</x-layouts.frontend-layout>
