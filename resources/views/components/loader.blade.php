<div {{ $attributes->merge([
    'class' => 'position-fixed flex-column align-items-center justify-content-center text-light',
    'style' => 'top:0;left:0;right:0;bottom:0;z-index:9999;background:rgba(0,0,0,0.5);gap:0.5rem',
    'wire:loading.class' => 'd-flex',
]) }}>
    <div class="spinner-border" role="status">
        <span class="sr-only">Loading...</span>
    </div>
    <span>Processing...</span>
</div>