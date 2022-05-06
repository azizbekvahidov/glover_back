<div>

    <x-baseview title="Contact Info">

        <x-form action="saveContactInfo" backPressed="$emitUp('goBack')">
            <p>
                <span class="font-bold">Link:</span>
                <br />
                <a href="{{ url(route('contact')) }}" target="_blank" class="underline">{{ url(route('contact')) }}</a>
            </p>
            <div class="w-full md:w-4/5 lg:w-5/12">

                <div class="mb-4">
                    <x-label title="Contact Info"/>
                    <p class="text-xs italic text-red-500">* Html code allowed</p>
                </div>
                <textarea id="contactInfo" wire:model.defer="contactInfo" class="w-full h-64 p-2 border border-black rounded-sm"></textarea>
                <x-buttons.primary title="{{ __('Save Changes') }}" />

            <div>
        </x-form>

    </x-baseview>



</div>




