<?php

// lang/hu/imports.php

return [
    // Page Title & Header
    'title' => 'Étlap Importálása',

    // Import Type Selection
    'form_select_type' => 'Válassza ki az importálás típusát:',
    'type_csv_title' => 'CSV / Excel (Strukturált)',
    'type_csv_desc' => 'A legjobb eredmény érdekében használja sablonunkat.',
    'type_pdf_title' => 'PDF Szkennelés (MI-alapú)',
    'type_pdf_desc' => 'Hamarosan elérhető: MI-nk elemzi a PDF étlapját.',
    'type_pdf_soon' => 'Hamarosan elérhető',

    // File Upload Area
    'upload_label' => 'Fájl feltöltése',
    'upload_button_select' => 'Fájl kiválasztása',
    'upload_button_change' => 'Fájl cseréje',
    'upload_drag_drop' => 'vagy húzza ide',
    'upload_file_specs' => 'CSV, XLSX, XLS, legfeljebb 5MB',

    // Submit Button
    'submit_button_start' => 'Importálás indítása',
    'submit_button_processing' => 'Feldolgozás...',

    // Instructions Panel
    'instructions_title' => 'Importálási Útmutató',
    'instructions_step_1' => 'Töltse le a CSV sablonunkat. Ez biztosítja a helyes formátumot és a speciális karakterek kezelését.',
    'instructions_step_2' => 'Gondosan töltse ki az oszlopokat. Ügyeljen a típusra (:food vagy :drink) és az ár formátumára.',
    'instructions_step_3' => 'Töltse fel a fájlt a bal oldali űrlapon. A meglévő, azonos nevű ételek ugyanabban a kategóriában frissülnek.',
    'download_template_button' => 'CSV Sablon Letöltése',

    // Validation Errors
    'validation_error_details' => 'Az importálási hibák részletei:',

    // Controller Feedback Messages
    'success_message' => 'Az étlap importálása sikeres volt!',
    'validation_error_summary' => 'Az importálás hibákat tartalmazott. Kérjük, ellenőrizze a részleteket és javítsa a fájlt.',
    'unexpected_error' => 'Váratlan technikai hiba történt. Az importálást megszakítottuk.',
    'pdf_not_ready' => 'A PDF MI importálás még fejlesztés alatt áll.',
];