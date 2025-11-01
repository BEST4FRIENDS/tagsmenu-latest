<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Post::firstOrCreate(['slug' => 'top-5-social-media-tipps'], [
            'title' => 'Top 5 Social-Media-Tipps für mehr Gäste in Ihrem Restaurant',
            'excerpt' => 'Erfahren Sie, wie Sie mit einfachen, aber effektiven Social-Media-Strategien die Sichtbarkeit Ihres Restaurants erhöhen und neue Kunden gewinnen können.',
            'body' => 'In der heutigen digitalen Welt ist eine starke Online-Präsenz für Restaurants unerlässlich. Social Media ist dabei mehr als nur eine Werbeplattform; es ist ein direkter Draht zu Ihren aktuellen und potenziellen Gästen. Hier sind fünf praxiserprobte Tipps...',
            'author' => 'Jane Doe',
            'published_at' => now()->subDays(2),
        ]);

        Post::firstOrCreate(['slug' => 'nachhaltigkeit-in-der-kueche'], [
            'title' => 'Nachhaltigkeit in der Küche: Mehr als nur ein Trend',
            'excerpt' => 'Von regionalen Zutaten bis zur Abfallvermeidung: So setzen Sie Nachhaltigkeit in Ihrem Gastronomiebetrieb erfolgreich um und sprechen umweltbewusste Gäste an.',
            'body' => 'Nachhaltigkeit ist ein Thema, das immer mehr an Bedeutung gewinnt. Auch in der Gastronomie suchen Gäste gezielt nach Betrieben, die verantwortungsvoll mit Ressourcen umgehen...',
            'author' => 'John Smith',
            'published_at' => now()->subDays(7),
        ]);

        Post::firstOrCreate(['slug' => 'das-perfekte-ambiente'], [
            'title' => 'Das perfekte Ambiente: Licht, Musik und Dekoration',
            'excerpt' => 'Das Auge isst mit – das gilt auch für die Umgebung. Wir zeigen Ihnen, wie Sie mit kleinen Änderungen eine unvergessliche Atmosphäre schaffen.',
            'body' => 'Ein hervorragendes Essen ist nur die halbe Miete. Das Ambiente eines Restaurants trägt maßgeblich zum Gesamterlebnis bei. Licht, Musik und Dekoration sind die drei Säulen...',
            'author' => 'Emily White',
            'published_at' => now()->subDays(12),
        ]);
    }
}