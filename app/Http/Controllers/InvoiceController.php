<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Setting;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Transaction $transaction)
    {
        $setting = Setting::get();
        $transaction->load('actions','drugMedDevs','paymentMethods','laborates');
        $branch = Branch::find(auth()->user()->branch_filter);
        return view('livewire.payment.payment2', compact('transaction','setting','branch'));
        // $pdf = Pdf::loadView('livewire.payment.invoice', compact('transaction','setting'))->setPaper('a5', 'landscape');
        // return $pdf->stream('invoice.pdf');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
