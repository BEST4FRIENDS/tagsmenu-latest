// resources/js/app.js

import './bootstrap';

// Importiere Alpine.js und mache es global verfügbar
import Alpine from 'alpinejs';
window.Alpine = Alpine;

// WICHTIG: Rufe hier NICHT Alpine.start() auf!
// Livewire wird es im Dashboard starten. Wir starten es manuell auf der öffentlichen Seite.