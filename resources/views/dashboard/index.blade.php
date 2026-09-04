@use('Pajak\Ui\Common\Enums\EmptyState\EmptyStateVariant')

<x-pajak-core::layout.admin :title="__('pajak-core::dashboard.title')">
    <x-pajak-core::page-header
        :title="__('pajak-core::dashboard.title')"
        :description="__('pajak-core::dashboard.subtitle')"
    />

    <div class="pajak-core-dashboard">
        <x-pajak::empty-state :variant="EmptyStateVariant::Dashed">
            <x-slot:icon>
                <x-heroicon-o-squares-2x2 width="28" height="28" aria-hidden="true" />
            </x-slot:icon>
            <x-slot:title>{{ __('pajak-core::dashboard.empty.title') }}</x-slot:title>
            <x-slot:message>{{ __('pajak-core::dashboard.empty.message') }}</x-slot:message>
        </x-pajak::empty-state>
    </div>
</x-pajak-core::layout.admin>
