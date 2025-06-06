<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Carbon\Carbon;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-line';
    protected static ?string $navigationLabel = 'Dashboards';
    protected static string $view = 'filament.admin.pages.dashboard';

    protected function getHeaderWidgets(): array
    {
        return [];
    }
    public array $birthdaysThisMonth = [];

    public function mount(): void
    {
        $this->birthdaysThisMonth = $this->getBirthdays();
    }

    public function getBirthdays(): array
    {
        $allBirthdays = [
            ['name' => 'Pillar Hernandez', 'date' => '6-Nov', 'position' => 'Funcionário'],
            ['name' => 'Claudia Gutierrez', 'date' => '27-Aug', 'position' => 'Funcionário'],
            ['name' => 'Jenniffer Casanova', 'date' => '12-Jul', 'position' => 'Funcionário'],
            ['name' => 'Yulie Rey', 'date' => '19-Nov', 'position' => 'Funcionário'],
            ['name' => 'Francisco Mello', 'date' => '12-Mar', 'position' => 'Funcionário'],
            ['name' => 'Marcos Santos', 'date' => '29-May', 'position' => 'Funcionário'],
            ['name' => 'Fernando Gutierrez', 'date' => '20-Nov', 'position' => 'Funcionário'],
            ['name' => 'Cesare Pluchino', 'date' => '14-Jan', 'position' => 'Funcionário'],
            ['name' => 'Kendrick Liwanag', 'date' => '31-Oct', 'position' => 'Funcionário'],
            ['name' => 'Joyce Kua', 'date' => '28-Nov', 'position' => 'Funcionário'],
            ['name' => 'Mônica Anjos', 'date' => '20-Dec', 'position' => 'Prestador'],
            ['name' => 'Paulo Magalhães', 'date' => '21-Aug', 'position' => 'Prestador'],
            ['name' => 'Thiago Oliveira', 'date' => '22-Oct', 'position' => 'Prestador'],
            ['name' => 'Paola Femeninas', 'date' => '29-Mar', 'position' => 'Prestador'],
            ['name' => 'Rodrigo Duarte Ferrari', 'date' => '5-May', 'position' => 'Consultor'],
            ['name' => 'Patricia Rangel', 'date' => '11-Apr', 'position' => 'Consultor'],
            ['name' => 'Larsa Youssef', 'date' => '1-Jan', 'position' => 'Consultor'],
            ['name' => 'Luiz de Lima', 'date' => '17-Jun', 'position' => 'Consultor'],
            ['name' => 'Emanuel Kozerski', 'date' => '16-May', 'position' => 'Consultor'],
            ['name' => 'Lucas Rodrigues', 'date' => '25-Aug', 'position' => 'Consultor'],
            ['name' => 'Cinthia da Silva Cortes', 'date' => '22-May', 'position' => 'Consultor'],
            ['name' => 'Maria Ximena Bejarano Rojas', 'date' => '18-Apr', 'position' => 'Consultor'],
            ['name' => 'Teresa Incerto', 'date' => '21-Jul', 'position' => 'Consultor'],
            ['name' => 'Paola Daza', 'date' => '8-Nov', 'position' => 'Consultor'],
            ['name' => 'Sebastian Mora', 'date' => '9-Aug', 'position' => 'Consultor'],
            ['name' => 'David Romero', 'date' => '5-Oct', 'position' => 'Consultor'],
            ['name' => 'Dario Rojas', 'date' => '18-Nov', 'position' => 'Consultor'],
            ['name' => 'Sebastian Socha', 'date' => '25-Mar', 'position' => 'Consultor'],
            ['name' => 'Estibaliz Lippez', 'date' => '14-Dec', 'position' => 'Consultor'],
            ['name' => 'Erika Torres', 'date' => '13-Apr', 'position' => 'Consultor'],
            ['name' => 'Astrid Alvarez', 'date' => '11-Aug', 'position' => 'Consultor'],
        ];

        $currentMonth = Carbon::now()->format('M');
        $birthdaysThisMonth = array_filter($allBirthdays, function ($birthday) use ($currentMonth) {
            return str_contains($birthday['date'], $currentMonth);
        });

        return array_values($birthdaysThisMonth); // Return filtered list
    }
}
