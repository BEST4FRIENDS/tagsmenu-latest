<?php

// lang/sk/imports.php

return [
    // Page Title & Header
    'title' => 'Importovať Menu',

    // Import Type Selection
    'form_select_type' => 'Vyberte typ importu:',
    'type_csv_title' => 'CSV / Excel (Štruktúrovaný)',
    'type_csv_desc' => 'Pre najlepšie výsledky použite našu šablónu.',
    'type_pdf_title' => 'Skenovanie PDF (s podporou UI)',
    'type_pdf_desc' => 'Už čoskoro: Naša UI analyzuje vaše PDF menu.',
    'type_pdf_soon' => 'Už čoskoro',

    // File Upload Area
    'upload_label' => 'Nahrať súbor',
    'upload_button_select' => 'Vybrať súbor',
    'upload_button_change' => 'Zmeniť súbor',
    'upload_drag_drop' => 'alebo presuňte súbor sem',
    'upload_file_specs' => 'CSV, XLSX, XLS do 5MB',

    // Submit Button
    'submit_button_start' => 'Spustiť Import',
    'submit_button_processing' => 'Spracováva sa...',

    // Instructions Panel
    'instructions_title' => 'Návod na Import',
    'instructions_step_1' => 'Stiahnite si našu CSV šablónu. Tým sa zabezpečí správny formát a špeciálne znaky.',
    'instructions_step_2' => 'Stĺpce vyplňte pozorne. Dávajte pozor na typ (:food alebo :drink) a formát ceny.',
    'instructions_step_3' => 'Nahrajte súbor do formulára vľavo. Existujúce jedlá s rovnakým názvom v rovnakej kategórii budú aktualizované.',
    'download_template_button' => 'Stiahnuť CSV Šablónu',

    // Validation Errors
    'validation_error_details' => 'Podrobnosti o chybách importu:',

    // Controller Feedback Messages
    'success_message' => 'Vaše menu bolo úspešne importované!',
    'validation_error_summary' => 'Import obsahoval chyby. Skontrolujte podrobnosti nižšie a opravte súbor.',
    'unexpected_error' => 'Vyskytla sa neočakávaná technická chyba. Import bol zrušený.',
    'pdf_not_ready' => 'Import PDF pomocou UI je stále vo vývoji.',
];