<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'livewire' => null,
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'livewire' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<!DOCTYPE html>
<html
    lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>"
    dir="<?php echo e(__('filament-panels::layout.direction') ?? 'ltr'); ?>"
    class="<?php echo \Illuminate\Support\Arr::toCssClasses([
        'fi min-h-screen',
        'dark' => filament()->hasDarkModeForced(),
    ]); ?>"
>
    <head>
        <?php echo e(\Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::HEAD_START, scopes: $livewire->getRenderHookScopes())); ?>


        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />

        <?php if($favicon = filament()->getFavicon()): ?>
            <link rel="icon" href="<?php echo e($favicon); ?>" />
        <?php endif; ?>

        <?php
            $title = trim(strip_tags(($livewire ?? null)?->getTitle() ?? ''));
            $brandName = trim(strip_tags(filament()->getBrandName()));
        ?>

        <title>
            <?php echo e(filled($title) ? "{$title} - " : null); ?> <?php echo e($brandName); ?>

        </title>

        <?php echo e(\Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::STYLES_BEFORE, scopes: $livewire->getRenderHookScopes())); ?>


        <style>
            [x-cloak=''],
            [x-cloak='x-cloak'],
            [x-cloak='1'] {
                display: none !important;
            }

            @media (max-width: 1023px) {
                [x-cloak='-lg'] {
                    display: none !important;
                }
            }

            @media (min-width: 1024px) {
                [x-cloak='lg'] {
                    display: none !important;
                }
            }
        </style>

        <?php echo \Filament\Support\Facades\FilamentAsset::renderStyles() ?>

        <?php echo e(filament()->getTheme()->getHtml()); ?>

        <?php echo e(filament()->getFontHtml()); ?>


        <style>
            :root {
                --font-family: '<?php echo filament()->getFontFamily(); ?>';
                --sidebar-width: <?php echo e(filament()->getSidebarWidth()); ?>;
                --collapsed-sidebar-width: <?php echo e(filament()->getCollapsedSidebarWidth()); ?>;
                --default-theme-mode: <?php echo e(filament()->getDefaultThemeMode()->value); ?>;
            }
        </style>

        <?php echo $__env->yieldPushContent('styles'); ?>

        <?php echo e(\Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::STYLES_AFTER, scopes: $livewire->getRenderHookScopes())); ?>


        <?php if(! filament()->hasDarkMode()): ?>
            <script>
                localStorage.setItem('theme', 'light')
            </script>
        <?php elseif(filament()->hasDarkModeForced()): ?>
            <script>
                localStorage.setItem('theme', 'dark')
            </script>
        <?php else: ?>
            <script>
                const loadDarkMode = () => {
                    window.theme = localStorage.getItem('theme') ?? <?php echo \Illuminate\Support\Js::from(filament()->getDefaultThemeMode()->value)->toHtml() ?>

                    if (
                        window.theme === 'dark' ||
                        (window.theme === 'system' &&
                            window.matchMedia('(prefers-color-scheme: dark)').matches)
                    ) {
                        document.documentElement.classList.add('dark')
                    }
                }

                loadDarkMode()
                document.addEventListener('livewire:navigated', loadDarkMode)
            </script>
        <?php endif; ?>

        <?php echo e(\Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::HEAD_END, scopes: $livewire->getRenderHookScopes())); ?>

    </head>

    <body
        <?php echo e($attributes
                ->merge(($livewire ?? null)?->getExtraBodyAttributes() ?? [], escape: false)
                ->class([
                    'fi-body',
                    'fi-panel-' . filament()->getId(),
                    'min-h-screen bg-gray-50 font-normal text-gray-950 antialiased dark:bg-gray-950 dark:text-white',
                ])); ?>

    >
        <?php echo e(\Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::BODY_START, scopes: $livewire->getRenderHookScopes())); ?>


        <?php echo e($slot); ?>


        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split(Filament\Livewire\Notifications::class);

$__html = app('livewire')->mount($__name, $__params, 'lw-926148788-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>

        <?php echo e(\Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::SCRIPTS_BEFORE, scopes: $livewire->getRenderHookScopes())); ?>


        <?php echo \Filament\Support\Facades\FilamentAsset::renderScripts(withCore: true) ?>
<?php echo \Filament\Support\Facades\FilamentAsset::renderScripts(withCore: true) ?>

<script>
// Force-add CSRF header to ALL fetch() requests (covers Livewire too)
(() => {
  const meta = document.querySelector('meta[name="csrf-token"]');
  if (!meta) return;
  const token = meta.getAttribute('content');
  if (!token) return;

  // patch window.fetch once
  const _fetch = window.fetch;
  window.fetch = function (input, init) {
    init = init || {};
    // normalize headers
    let headers = new Headers(init.headers || {});
    if (!headers.has('X-CSRF-TOKEN')) {
      headers.set('X-CSRF-TOKEN', token);
    }
    init.headers = headers;
    return _fetch(input, init);
  };
})();
</script>

        
        <script>
        document.addEventListener('livewire:init', () => {
            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            if (token && window.Livewire) {
                window.Livewire.setHeaders({
                    'X-CSRF-TOKEN': token,
                });
            }
        });
        </script>

        <?php if(filament()->hasBroadcasting() && config('filament.broadcasting.echo')): ?>
            <script data-navigate-once>
                window.Echo = new window.EchoFactory(<?php echo \Illuminate\Support\Js::from(config('filament.broadcasting.echo'))->toHtml() ?>)
                window.dispatchEvent(new CustomEvent('EchoLoaded'))
            </script>
        <?php endif; ?>

        <?php if(filament()->hasDarkMode() && (! filament()->hasDarkModeForced())): ?>
            <script>
                loadDarkMode()
            </script>
        <?php endif; ?>

        <?php echo $__env->yieldPushContent('scripts'); ?>

        <?php echo e(\Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::SCRIPTS_AFTER, scopes: $livewire->getRenderHookScopes())); ?>


        <?php echo e(\Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::BODY_END, scopes: $livewire->getRenderHookScopes())); ?>

    </body>
</html>
<?php /**PATH C:\Users\Admin\haninge\resources\views/vendor/filament-panels/components/layout/base.blade.php ENDPATH**/ ?>