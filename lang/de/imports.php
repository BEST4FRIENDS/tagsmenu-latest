<?php

// lang/de/imports.php

return [
    // Page Title & Header
    'title' => 'Speisekarte Importieren',

    // Import Type Selection
    'form_select_type' => 'Wählen Sie den Import-Typ:',
    'type_csv_title' => 'CSV / Excel (Strukturiert)',
    'type_csv_desc' => 'Verwenden Sie unsere Vorlage für beste Ergebnisse.',
    'type_pdf_title' => 'PDF-Scan (KI-gestützt)',
    'type_pdf_desc' => 'Bald verfügbar: Unsere KI analysiert Ihre PDF-Karte.',
    'type_pdf_soon' => 'Bald verfügbar',

    // File Upload Area
    'upload_label' => 'Datei hochladen',
    'upload_button_select' => 'Datei auswählen',
    'upload_button_change' => 'Datei ändern',
    'upload_drag_drop' => 'oder Drag & Drop',
    'upload_file_specs' => 'CSV, XLSX, XLS bis zu 5MB',

    // Submit Button
    'submit_button_start' => 'Import starten',
    'submit_button_processing' => 'Wird verarbeitet...',

    // Instructions Panel
    'instructions_title' => 'Anleitung zum Import',
    'instructions_step_1' => 'Laden Sie unsere CSV-Vorlage herunter. Dies stellt sicher, dass Format und Sonderzeichen korrekt sind.',
    'instructions_step_2' => 'Füllen Sie die Spalten sorgfältig aus. Achten Sie auf den Typ (:food oder :drink) und das Preisformat.',
    'instructions_step_3' => 'Laden Sie die Datei im Formular links hoch. Bestehende Gerichte mit gleichem Namen in der gleichen Kategorie werden aktualisiert.',
    'download_template_button' => 'CSV-Vorlage herunterladen',

    // Validation Errors
    'validation_error_details' => 'Details zu den Importfehlern:',

    // Controller Feedback Messages
    'success_message' => 'Ihre Speisekarte wurde erfolgreich importiert!',
    'validation_error_summary' => 'Der Import enthielt Fehler. Bitte prüfen Sie die Details und korrigieren Sie Ihre Datei.',
    'unexpected_error' => 'Ein unerwarteter technischer Fehler ist aufgetreten. Der Import wurde abgebrochen.',
    'pdf_not_ready' => 'Der PDF KI Import ist noch in Entwicklung.',
];