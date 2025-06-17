<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Models\Pdf_folder;
use League\CommonMark\CommonMarkConverter;
use App\Api;


class PdfController extends Controller
{
    public function index()
    {
        $pdfs = Pdf_folder::all();
        return view('pdfs.index_pdfs', compact('pdfs'));
    }

    public function create()
    {
        return view('pdfs.create');
    }

    public function store(Request $request)
    {
        $pdfFile = $request->file('pdf_file');
        if (!$pdfFile) {
        dd('Arquivo não enviado!');
        }
        $userId = auth()->user()->id;
        $filename = $request->pdf_title . '.pdf';

        $pdfFile = $request->file('pdf_file');
        $path = $pdfFile->storeAs("pdfs/{$userId}", $filename, 'local');
        if (!$path) {
            dd('Falha ao salvar o arquivo');
        }
        $user_id = auth()->user()->id;
        $request_api = Http::timeout(120)->get(Api::endpoint().'/new_pdf_folder/'.$user_id.'/'.$request->pdf_title);
        if ($request_api->failed()) {
            dd('Falha na requisição');
        }

        $data_api = $request_api->json();
        Pdf_folder::create([
            'user_id' => auth()->user()->id,
            'name' => $request->pdf_title,
            'summary' => $data_api['summary'],
            'content' => $data_api['content'],
            'pages' => $data_api['pages'],
            'size' => $data_api['size'],
            'words' => $data_api['words'],
            'language' => $data_api['language'],
        ]);

        return redirect()->back()->withSuccess('PDF enviado com sucesso.');
    }

    public function show(Pdf_folder $pdf)
    {
        $converter = new CommonMarkConverter();
        $content = $converter->convertToHtml($pdf->content);
        return view('pdfs.pdf_view', compact('pdf', 'content'));
    }

    public function edit(Pdf_folder $pdf)
    {
        return view('pdfs.edit', compact('pdf'));
    }

    public function update(Request $request, Pdf_folder $pdf)
    {
        $request->validate([
            'nome' => 'required'
        ]);

        $pdf->update($request->all());
        return redirect()->route('pdf.index')->with('success', 'PDF atualizado com sucesso!');
    }

    public function destroy(Pdf_folder $pdf)
    {
        $pdf->delete();
        return redirect()->route('pdf.index')->with('success', 'PDF removido com sucesso!');
    }
}

