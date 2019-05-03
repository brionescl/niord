<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Expense;

class ExpenseController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Expense::where('user_id', auth()->id())->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $expense = new Expense();
        $expense->user_id = auth()->id();
        $expense->category_id = $request->category_id;
        $expense->currency_id = $request->currency_id;
        $expense->description = $request->description;
        $expense->amount = $request->amount;
        $expense->save();

        return $expense;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $expense = Expense::find($id);
        $expense->category_id = $request->category_id;
        $expense->currency_id = $request->currency_id;
        $expense->description = $request->description;
        $expense->amount = $request->amount;
        $expense->save();

        return $expense;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $expense = Expense::find($id);
        $expense->delete();

        return response('', 204);
    }
}
