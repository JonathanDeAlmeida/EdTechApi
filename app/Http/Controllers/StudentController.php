<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Student;

class StudentController extends Controller
{
    public function get ()
    {
        // Buscando todos os alunos
        try {

            $students = Student::get();
            return response()->json($students, 200);

        } catch (\Exception $e) {

            return response()->json($e->getMessage() . ' - ' . $e->getLine() . ' - ' . $e->getFile(), 400);
        }
    }

    public function filter (Request $request) 
    {
        // Buscando os alunos por filtro
        try {

            $data = $request->all();
            $data = json_encode($request->all());
            $obj_filter = json_decode($data);

            $students = Student::where(function($query) use ($obj_filter) {
                if ($obj_filter) {
                    $query->where('name', 'LIKE', "%$obj_filter->filter%")
                    ->orWhere('document', 'LIKE', "%$obj_filter->filter%")
                    ->orWhere('academic_register', 'LIKE', "%$obj_filter->filter%")
                    ->orWhere('email', 'LIKE', "%$obj_filter->filter%");
                }
            })->get();

            return response()->json($students, 200);

        } catch (\Exception $e) {

            return response()->json($e->getMessage() . ' - ' . $e->getLine() . ' - ' . $e->getFile(), 400);
        }
    }

    public function save (Request $request)
    {
        // Salvando o aluno no cadastro ou edição
        try {

            $data = $request->all();

            DB::beginTransaction();

            if ($data['id']) {
                $student = Student::where('id', $data['id'])->first();
            } else {
                $student = new Student();
            }

            $student->name = $data['name'];
            $student->document = $data['document'];
            $student->academic_register = $data['academic_register'];
            $student->email = $data['email'];
            $student->save();
            
            DB::commit();

            return response()->json('Aluno cadastrado com sucesso', 200);

        } catch (\Exception $e) {

            return response()->json($e->getMessage() . ' - ' . $e->getLine() . ' - ' . $e->getFile(), 400);
        }
    }

    public function remove (Request $request)
    {
        // Excluindo o aluno
        try {

            $data = $request->all();
            Student::where('id', $data['id'])->delete();

            return response()->json('Aluno excluido com sucesso', 200);

        } catch (\Exception $e) {

            return response()->json($e->getMessage() . ' - ' . $e->getLine() . ' - ' . $e->getFile(), 400);
        }
    }
}
