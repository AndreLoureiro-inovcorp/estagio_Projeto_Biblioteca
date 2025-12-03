<div>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            Recusar Review
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4">
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <p class="text-sm text-gray-600 mb-4">
                        Será enviado um email com a justificação abaixo.
                    </p>

                    <form wire:submit.prevent="recusar">

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-semibold">Justificação:</span>
                            </label>
                            <textarea wire:model="justificacao_recusada" rows="5" class="textarea textarea-bordered w-full" placeholder="Motivo para ser recusado"></textarea>
                            @error('justificacao_recusada')
                            <span class="text-error text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex gap-3 justify-end mt-6">
                            <a href="{{ route('admin.reviews') }}" class="btn btn-ghost">
                                Cancelar
                            </a>
                            <button type="submit" class="text-center bg-red-600 hover:bg-red-700 text-white text-sm font-medium py-1.5 px-3 rounded-md transition duration-200 shadow-sm">
                                Enviar justificação
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
