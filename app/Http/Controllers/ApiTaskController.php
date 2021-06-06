<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiTaskController extends Controller
{
    //
    public function gettask(Request $request)
    {
        if($request->user_id === $request->user()->id){
            $postsUser = DB::table('tasks')->where('user_id', $request->user_id)->get();

            if (!$postsUser){
                return response()->json(["message"=>"Tache non trouvé"], 404);
            }

            return response()->json([
                'posts'=>$postsUser
            ], 201);
        }
        else{
            return response()->json(["message"=>"Accès à la tâche non autorisé"], 403);
        }

    }

    public function store(Request $request)
    {
        $request->validate([
            'body' => 'required',
            'user_id' => 'required',
        ]);

        Task::create([
            'body' => $request->body,
            'user_id' => $request->user_id,
        ]);

        return response()->json(['msg' => 'Enregistrement effectué'], 201);
    }

    public function destroy($id, Request $request)
    {
        $postToDelete = Task::where('id', $id)->first();

        if($postToDelete){
            // dd($postToDelete[0]->id === $request->user()->id);
            if($postToDelete->user_id === $request->user()->id){
                Task::where('id', $id )->delete();
                return response()->json(['message'=>'OK'], 200);
            }
            else{
                return response()->json(["message"=>"Accès à la tâche non autorisé"], 403);
            }
        }
        return response()->json(['error'=>'La tâche n\'existe pas'], 404);
    }

    public function update(Request $request, $id)
    {
        $task = Task::find($id);

        if(!$task) {
            return response()->json(["message" => "La tâche n\'existe pa"], 404);
        }

        if($task->user->id != $request->user()->id) {
            return response()->json(["message"=>"Accès à la tâche non autorisé"], 403);
        }

        $request->validate([
            'body' => 'required',
        ]);
        $task = Task::where('id', $id)->first();
        $task->body = $request->body;
        $task->save();

        return response()->json(['message'=>'OK'], 200);
    }


}
