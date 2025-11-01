<?php

// lang/en/imports.php

return [
    // Page Title & Header
    'title' => 'Import Menu',

    // Import Type Selection
    'form_select_type' => 'Select the import type:',
    'type_csv_title' => 'CSV / Excel (Structured)',
    'type_csv_desc' => 'Use our template for the best results.',
    'type_pdf_title' => 'PDF Scan (AI-assisted)',
    'type_pdf_desc' => 'Coming soon: Our AI will analyze your PDF menu.',
    'type_pdf_soon' => 'Coming soon',

    // File Upload Area
    'upload_label' => 'Upload file',
    'upload_button_select' => 'Choose file',
    'upload_button_change' => 'Change file',
    'upload_drag_drop' => 'or Drag & Drop',
    'upload_file_specs' => 'CSV, XLSX, XLS up to 5MB',

    // Submit Button
    'submit_button_start' => 'Start Import',
    'submit_button_processing' => 'Processing...',

    // Instructions Panel
    'instructions_title' => 'Import Instructions',
    'instructions_step_1' => 'Download our CSV template. This ensures that the format and special characters are correct.',
    'instructions_step_2' => 'Fill in the columns carefully. Pay attention to the type (:food or :drink) and the price format.',
    'instructions_step_3' => 'Upload the file using the form on the left. Existing dishes with the same name in the same category will be updated.',
    'download_template_button' => 'Download CSV Template',

    // Validation Errors
    'validation_error_details' => 'Details of the import errors:',

    // Controller Feedback Messages
    'success_message' => 'Your menu was imported successfully!',
    'validation_error_summary' => 'The import contained errors. Please check the details below and correct your file.',
    'unexpected_error' => 'An unexpected technical error occurred. The import has been canceled.',
    'pdf_not_ready' => 'The PDF AI import is still under development.',
];