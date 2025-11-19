<div class="stats shadow w-full flex flex-col md:flex-row justify-center text-center bg-white">

    <div class="stat place-items-center">
        <div class="stat-title font-bold">Requisições Ativas</div>
        <div class="stat-value text-primary">{{ $requisicoesAtivas }}</div>
    </div>

    <div class="stat place-items-center">
        <div class="stat-title font-bold">Requisições nos últimos 30 dias</div>
        <div class="stat-value text-primary">{{ $requisicoesUltimos30Dias }}</div>
    </div>

    <div class="stat place-items-center">
        <div class="stat-title font-bold">Livros entregues Hoje</div>
        <div class="stat-value text-primary">{{ $livrosEntreguesHoje }}</div>
    </div>

</div>
