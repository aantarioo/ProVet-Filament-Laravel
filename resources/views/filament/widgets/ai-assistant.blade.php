<x-filament-widgets::widget>
    <x-filament::section>
        <h2 class="text-lg font-bold mb-2">Using AI directly in the panel</h2>

        <div class="space-y-4">
            <x-filament::input.wrapper>
                <x-filament::input
                    wire:model="question"
                    placeholder="Describe the pet's symptoms..."
                />
            </x-filament::input.wrapper>

            <x-filament::button wire:click="ask">Ask</x-filament::button>

            @if($answer)
                <div class="p-3 rounded-lg">
                    <strong>Answer:</strong> {{ $answer }}
                </div>
            @endif
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
