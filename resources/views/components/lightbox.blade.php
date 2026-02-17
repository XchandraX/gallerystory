{{-- resources/views/components/lightbox.blade.php --}}
<div id="lightbox" class="fixed inset-0 bg-black/80 hidden items-center justify-center z-50" role="dialog" aria-modal="true">
    <button onclick="closeLightbox()" class="absolute top-4 right-4 text-white text-4xl hover:text-gray-300 focus:outline-none" aria-label="Close">&times;</button>
    <img id="lightbox-img" src="" class="max-h-[90vh] max-w-[90vw] rounded-lg shadow-2xl" alt="">
</div>

@push('scripts')
    <script src="{{ asset('js/lightbox.js') }}" defer></script>
@endpush