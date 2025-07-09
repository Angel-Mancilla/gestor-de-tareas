<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Throw_;
use Symfony\Component\Console\Input\Input;
use Symfony\Component\HttpFoundation\Response;

// use Symfony\Component\HttpFoundation\Response;



class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::select(['id','title','description','completed'])->get();
        
        return new JsonResponse($tasks);
        // return response()->json([
        //     'status' => true,
        //     // 'message' => 'Tasks were successfully retrieved',
        //     'tasks' => $tasks,
        // ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {   
        try {
            $task = Task::create($request->all());

            // return response()->json([
            //     'status' => true,
            //     'message' => 'Task created successfully',
            //     'task' => $task,

            // ], 200);
            return response()->json([
            'message' => 'Se ha guardado correctamente',
            'tast' => $task
            ],201);//response('', Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al guardar',
                'error' => $e->getMessage()
            ],500);
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $requestValidated = $request->validated();
        if(array_key_exists('completed',$requestValidated)&&is_null($requestValidated['completed'])){

            $requestValidated['completed'] = false;

        }
        $updateTask = $task->update($requestValidated);

        // return response()->json([
        //     'status' => true,
        //     'message' => 'Task updated successfully',
        //     'task' => $updateTask
        // ],200);
        return response('', Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $request)
    {
        $request->delete();
    }
}
