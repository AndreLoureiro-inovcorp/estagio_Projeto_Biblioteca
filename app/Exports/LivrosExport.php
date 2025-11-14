<?php

namespace App\Exports;

use App\Models\Livro;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LivrosExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    public function collection()
    {
        return Livro::with(['editora', 'autores'])->get();
    }

    public function headings(): array
    {
        return [
            'ISBN',
            'Nome',
            'Editora',
            'Autores',
            'Bibliografia',
            'Preço',
            'Imagem da Capa'
        ];
    }

    public function map($livro): array
    {
        return [
            $livro->isbn,
            $livro->nome,
            $livro->editora ? $livro->editora->nome : 'N/A',
            $livro->autores->pluck('nome')->implode(', '),
            $livro->bibliografia,
            $livro->preco ? '€' . number_format($livro->preco, 2, ',', '.') : 'N/A',
            $livro->imagem_capa
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
