<?php

namespace App\Exports;

use App\Models\CategoryOutcome;
use App\Models\Outcome;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PengeluaranExport implements FromCollection, WithHeadings
{
    protected $date;
    protected $branch_id;

    public function __construct($date = null, $branch_id = null)
    {
        $this->date = $date;
        $this->branch_id = $branch_id;
    }
    public function collection()
    {
        $categories = CategoryOutcome::select('name')
        ->distinct()
        ->pluck('name');

        $dynamicColumns = $categories->map(function($category) {
            $columnName = str_replace([' ', '&', '@', '#', '$', '%', '^', '*', '(', ')'], '_', strtolower($category)) . '_total';
            return DB::raw("COALESCE(SUM(CASE WHEN outcomes.category = '$category' THEN CAST(outcomes.nominal AS INTEGER) ELSE 0 END), 0) as \"$columnName\"");
        });

        $totalNominal = DB::raw('COALESCE(SUM(' . $categories->map(function($category) {
            return "CASE WHEN outcomes.category = '$category' THEN CAST(outcomes.nominal AS INTEGER) ELSE 0 END";
        })->implode(' + ') . '), 0) as total_nominal');


        $query = Outcome::join('branches', 'outcomes.branch_id', '=', 'branches.id')
            ->select(array_merge(
                [
                    'outcomes.date',
                    'branches.name as branch_name'
                ],
                $dynamicColumns->toArray(),
                [$totalNominal]
            ));

            if (isset($this->date[0]) && isset($this->date[1])) {
                $query->where('outcomes.date', '>=', Carbon::parse($this->date[0])->format('Y-m-d'))
                        ->where('outcomes.date', '<=', Carbon::parse($this->date[1])->format('Y-m-d'));
            }else{
                $query->whereMonth('outcomes.date',Carbon::now()->format('m'));
            }
            if($this->branch_id != null){
                $query = $query->where('outcomes.branch_id', $this->branch_id);
            }
        $outcome = $query->groupBy('outcomes.date', 'branches.name')
        ->orderBy('outcomes.date','desc')
        ->get();

        $data = $outcome->map(function ($item){
            $columns = [
                'Tanggal' => $item->date,
                'Cabang' => $item->branch_name
            ];
            $categories = CategoryOutcome::select('name')
            ->distinct()
            ->pluck('name');

            foreach ($categories as $c) {
                $columnName = str_replace([' ', '&', '@', '#', '$', '%', '^', '*', '(', ')'], '_', strtolower($c)) . '_total';
                $columns[$columnName] = $item->{$columnName};
            }
            $columns['Total Pengeluaran'] = $item->total_nominal;
            return $columns;


        });

        return collect($data);
    }
    public function headings(): array
    {
        $categories = CategoryOutcome::select('name')
        ->distinct()
        ->pluck('name');

        return [
            'Tanggal',
            'Cabang',
            ...$categories->toArray(),
            'Total Pengeluaran',
        ];
    }

}
