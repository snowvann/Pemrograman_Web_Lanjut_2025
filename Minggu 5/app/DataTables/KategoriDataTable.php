<?php 
namespace App\DataTables;

use App\Models\KategoriModel;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Builder as HtmlBuilder;

class KategoriDataTable extends DataTable
{
    public function dataTable($query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($id) {
            $edit = route('kategori.edit', $id);
            $delete = route('kategori.delete', $id);
         
            return '<div style="display: flex; gap: 5px;">
                <a href="' . $edit . '" class="btn btn-warning btn-sm">Edit</a>
                <a href="' . $delete . '" class="btn btn-danger btn-sm btn-delete">Delete</a>
            </div>';
        })
            ->setRowId('id');
    }

    public function query(KategoriModel $model)
    {
        return $model->newQuery();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('kategori-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->selectStyleSingle()
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload'),
            ]);
    }

    public function getColumns(): array
    {
        return [
            Column::make('kategori_id'),
            Column::make('kategori_kode'),
            Column::make('kategori_nama'),
            Column::make('created_at'),
            Column::make('updated_at'),
            Column::computed('action')
                 -> exportable(false)
                 -> printable(false)
                 -> width(100)
                 -> addClass('text-center')
        ];
    }

    protected function filename(): string
    {
        return 'Kategori_' . date('YmdHis');
    }
}
