<?php

namespace App\Http\Controllers;

use App\Exports\ExcelListExport;
use App\Imports\ExcelListImport;
use App\Models\ExcelList;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    public function index()
    {
      return view('excel.index');
    }
    public function getAll()
    {
      $users = ExcelList::get();
      return response()->json(['data'=>$users]);
    }

    public function export()
    {
      return Excel::download(new ExcelListExport, 'excelList.xlsx');
    }

    public function import(Request $request)
    {
      $request->validate([
        'file'=>'required'
      ]);
      Excel::import(new ExcelListImport, $request->file('file'));
//      return back()->with('success', 'Users imported successfully.');
      return response()->json(['data'=>'Excel imported successfully.']);
    }

    public function drop()
    {
      try {
        DB::table('excel_lists')->truncate();
        return response()->json(['data' => 'All records deleted successfully.'], 200);
      } catch (\Exception $e) {
        return response()->json(['error' => 'Failed to delete data: ' . $e->getMessage()], 500);
      }
    }

    public function addColumn(Request $request)
    {
      try {
        $columnName = $request->input('column_name');
        if (!$columnName || !preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*$/', $columnName)) {
          return response()->json(['error' => 'Invalid column name'], 400);
        }
        if (Schema::hasColumn('excel_lists', $columnName)) {
          return response()->json(['error' => 'Column already exists'], 400);
        }
        $existingColumns = Schema::getColumnListing('excel_lists');
        if (count($existingColumns) >= 14) {
          return response()->json(['error' => 'Maximum column limit (12) reached'], 400);
        }
        Schema::table('excel_lists', function (Blueprint $table) use ($columnName) {
          $table->string($columnName)->nullable();
        });
        return response()->json(['message' => 'Column added successfully']);
      } catch (\Exception $e) {
        return response()->json(['error' => 'Failed to add column: ' . $e->getMessage()], 500);
      }
    }

    public function getColumns()
    {
      $columns = Schema::getColumnListing('excel_lists');
      return response()->json(['data' => $columns]);
    }
    public function dropColumn(Request $request)
    {
      $columns = $request->input('columns');
      if (empty($columns) || !is_array($columns)) {
        return response()->json(['error' => 'Invalid column selection.'], 400);
      }
      try {
        Schema::table('excel_lists', function (Blueprint $table) use ($columns) {
          foreach ($columns as $column) {
            if (Schema::hasColumn('excel_lists', $column)) {
              $table->dropColumn($column);
            }
          }
        });
        return response()->json(['data' => 'Selected columns dropped successfully.']);
      } catch (\Exception $e) {
        return response()->json(['error' => 'Failed to drop columns: ' . $e->getMessage()], 500);
      }
    }
}
