import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
    darkMode: 'class', // WICHTIG: Aktiviert den Dark Mode über Klassen (war bereits korrekt)

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                // Wir nutzen Poppins im Frontend, daher definieren wir es auch hier
                poppins: ['Poppins', 'sans-serif'],
            },
            // Füge die benutzerdefinierten Farben hinzu
            colors: {
                'crown-gold': {
                    DEFAULT: '#D4A056', // Ein warmer Goldton, ähnlich der Vorlage
                },
                // HINZUGEFÜGT: Definieren der spezifischen dunklen Töne des CROWN Designs
                'dark-bg': '#1A1A1A',   // Hintergrundfarbe (Sehr dunkles Grau/Schwarz)
                'dark-card': '#2C2C2C', // Farbe für die Karten/Elemente im Dark Mode
            },
        },
    },
    plugins: [forms],
};