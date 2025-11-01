<?php

namespace App\Http\Controllers;

use App\Imports\MenuImport;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ImportController extends Controller
{
    public function index(): View|RedirectResponse
    {
        if (!Auth::user()->restaurant) {
            // Diese Meldung kann auch übersetzt werden, falls nötig
            return redirect()->route('dashboard')->withErrors(['msg' => 'Bitte legen Sie zuerst ein Restaurant an.']);
        }
        return view('imports.index');
    }

    public function upload(Request $request): RedirectResponse
    {
        $restaurant = Auth::user()->restaurant;
        if (!$restaurant) abort(403);

        $type = $request->input('import_type');

        if ($type === 'pdf_ki') {
            return redirect()->route('imports.index')->with('warning', __('imports.pdf_not_ready'));
        }

        $request->validate([
            'import_file' => 'required|file|mimes:csv,txt,xlsx,xls|max:5120', // Max 5MB
        ]);

        try {
            Excel::import(new MenuImport($restaurant), $request->file('import_file'));

            return redirect()->route('categories.index')->with('success', __('imports.success_message'));

        } catch (ValidationException $e) {
            $failures = $e->failures();
            $errorMessages = [];
            foreach ($failures as $failure) {
                $errorMessages[] = "Zeile {$failure->row()}: {$failure->errors()[0]} (Spalte: {$failure->attribute()})";
            }

            return redirect()->route('imports.index')
                             ->withErrors(['import_errors' => $errorMessages])
                             ->with('error', __('imports.validation_error_summary'));

        } catch (\Exception $e) {
            \Log::error("Menu Import Failed Unexpectedly: " . $e->getMessage());
            return redirect()->route('imports.index')->with('error', __('imports.unexpected_error'));
        }
    }

    /**
     * Generiert die Vorlagendatei dynamisch und mehrsprachig zum Download (CSV).
     */
    public function downloadTemplate(): StreamedResponse
    {
        $headers = [
            "Content-type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=tagsmenu_import_vorlage.csv",
        ];

        // Neue, mehrsprachige und technische Spaltennamen für die Verarbeitung
        $columns = [
            'typ_fooddrink', 'preis',
            'kategorie_de', 'gericht_name_de', 'gericht_beschreibung_de',
            'kategorie_en', 'gericht_name_en', 'gericht_beschreibung_en',
            'kategorie_hu', 'gericht_name_hu', 'gericht_beschreibung_hu',
            'kategorie_sk', 'gericht_name_sk', 'gericht_beschreibung_sk',
        ];

        $callback = function() use ($columns) {
            $file = fopen('php://output', 'w');
            // WICHTIG: BOM hinzufügen für korrekte UTF-8/Umlaut Darstellung in Excel
            fputs($file, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) ));
            fputcsv($file, $columns);
            
            // Mehrsprachige Beispielzeilen
            $exampleRow1 = [
                'food', '9,50',
                'Vorspeisen', 'Kürbiscremesuppe', 'Leckere Suppe mit Kernöl.',
                'Appetizers', 'Pumpkin Cream Soup', 'Delicious soup with pumpkin seed oil.',
                'Előételek', 'Tökkrémleves', 'Ízletes leves tökmagolajjal.',
                'Predjedlá', 'Tekvicová krémová polievka', 'Chutná polievka s tekvicovým olejom.',
            ];
            fputcsv($file, $exampleRow1);

            $exampleRow2 = [
                'drink', '3.50',
                'Getränke', 'Mineralwasser 0.5L', '',
                'Drinks', 'Mineral Water 0.5L', '',
                'Italok', 'Ásványvíz 0.5L', '',
                'Nápoje', 'Minerálna voda 0.5L', '',
            ];
            fputcsv($file, $exampleRow2);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}