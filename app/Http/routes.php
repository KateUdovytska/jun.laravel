<?php

use App\Task;
use Illuminate\Http\Request;
Route::group(['prefix'=>'tasks'], function (){
    /**
     * Вывести панель с задачами
     */
    Route::get('/', function () {
        $tasks = Task::orderBy('created_at', 'asc')->get();

        return view('tasks.index', [
            'tasks'=>$tasks
        ]);
    })->name('tasks.all');

    /**
     * Добавить новую задачу
     */
    Route::post('/', function (Request $request) {
        $validator = Validator::make($request->all(),
            ['name'=>'required|max:255',
            ]);
            if($validator->fails()){
                return redirect(route('tasks.all'))
                    ->withInput()
                    ->withErrors($validator); //для вывода ошибок
            }
        $name = $request->name;
        $task = new Task();
        $task->name = $name;
        $task->save();
        return redirect(route('tasks.all'));
    })->name('tasks.add');

    /**
     * Удалить задачу
     */
    Route::delete('/{task}', function (Task $task) {
        $task->delete();
        return redirect(route('tasks.all'));
    })->name('tasks.delete');
});


