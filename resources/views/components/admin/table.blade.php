<div class="overflow-hidden bg-white border border-neutral-200/80 rounded-2xl">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-neutral-200">
            @if(isset($head))
                <thead class="bg-neutral-50/80">
                    <tr>
                        {{ $head }}
                    </tr>
                </thead>
            @endif
            <tbody class="divide-y divide-neutral-200 bg-white">
                {{ $slot }}
            </tbody>
        </table>
    </div>
    @if(isset($footer))
        <div class="border-t border-neutral-200 bg-neutral-50/50 px-4 py-3">
            {{ $footer }}
        </div>
    @endif
</div>
