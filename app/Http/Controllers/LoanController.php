<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loan;

class LoanController extends Controller
{
    // GET /api/loans
    public function index()
    {
        $loans = Loan::all();

        return response()->json([
            'data' => $loans,
            'message' => 'Loans retrieved successfully'
        ],200);
    }

    // POST /api/loans
    public function store(Request $request)
    {
        $validated = $request->validate([
            'borrower_name'=>'required|string',
            'borrower_email'=>'required|email',
            'book_title'=>'required|string',
            'borrowed_at'=>'required|date',
            'due_date'=>'required|date'
        ]);

        $loan = Loan::create($validated);

        return response()->json([
            'data'=>$loan,
            'message'=>'Loan created successfully'
        ],201);
    }

    // GET /api/loans/{id}
    public function show($id)
    {
        $loan = Loan::find($id);

        if(!$loan){
            return response()->json([
                'message'=>'Loan not found'
            ],404);
        }

        return response()->json([
            'data'=>$loan,
            'message'=>'Loan retrieved successfully'
        ],200);
    }

    // PUT /api/loans/{id}
    public function update(Request $request,$id)
    {
        $loan = Loan::find($id);

        if(!$loan){
            return response()->json([
                'message'=>'Loan not found'
            ],404);
        }

        $validated = $request->validate([
            'borrower_name'=>'required|string',
            'borrower_email'=>'required|email',
            'book_title'=>'required|string',
            'borrowed_at'=>'required|date',
            'due_date'=>'required|date'
        ]);

        $loan->update($validated);

        return response()->json([
            'data'=>$loan,
            'message'=>'Loan updated successfully'
        ],200);
    }

    // DELETE /api/loans/{id}
    public function destroy($id)
    {
        $loan = Loan::find($id);

        if(!$loan){
            return response()->json([
                'message'=>'Loan not found'
            ],404);
        }

        $loan->delete();

        return response()->json([
            'message'=>'Loan deleted successfully',
            'data'=>null
        ],204);
    }

    // PATCH /api/loans/{id}/return
    public function returnLoan($id)
    {
        $loan = Loan::find($id);

        if(!$loan){
            return response()->json([
                'message'=>'Loan not found'
            ],404);
        }

        $loan->returned = true;
        $loan->status = 'returned';
        $loan->save();

        return response()->json([
            'data'=>$loan,
            'message'=>'Loan returned successfully'
        ],200);
    }
}
