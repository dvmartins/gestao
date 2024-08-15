<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Http\Requests\StoreInvoiceRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{
    public function create()
    {
        return view('invoices.create');
    }

    public function store(StoreInvoiceRequest $request)
    {
        $path = $request->file('xml_file')->store('invoices');
        $xml = simplexml_load_file(storage_path('app/' . $path));

        if ($xml && $xml->NFe && $xml->NFe->infNFe && $xml->NFe->infNFe->emit) {
            if ((string) $xml->NFe->infNFe->emit->CNPJ !== '09066241000884') {
                return back()->withErrors(['xml_file' => 'CNPJ do emitente inválido.']);
            }
        } else {
            return back()->withErrors(['xml_file' => 'Estrutura do XML inválida.']);
        }

        if (empty($xml->NFe->infNFe->ide->nProt)) {
            return back()->withErrors(['xml_file' => 'Protocolo de autorização não preenchido.']);
        }

        $invoice = new Invoice();
        $invoice->invoice_number = (string) $xml->NFe->infNFe->ide->nNF;
        $invoice->invoice_date = (string) $xml->NFe->infNFe->ide->dhEmi;
        $invoice->emitter_cnpj = (string) $xml->NFe->infNFe->emit->CNPJ;
        $invoice->receiver_cnpj = (string) $xml->NFe->infNFe->dest->CNPJ;
        $invoice->total_value = (float) $xml->NFe->infNFe->total->ICMSTot->vNF;
        $invoice->xml_path = $path;
        $invoice->save();

        return redirect()->route('invoices.index');
    }

    public function index(Request $request)
    {
        $invoices = Invoice::query();

        if ($request->filled('invoice_number')) {
            $invoices->where('invoice_number', $request->invoice_number);
        }

        if ($request->filled('emitter_cnpj')) {
            $invoices->where('emitter_cnpj', $request->emitter_cnpj);
        }

        $invoices = $invoices->get();

        return view('invoices.index', compact('invoices'));
    }

    public function download(Invoice $invoice)
    {
        return Storage::download($invoice->xml_path);
    }
}
