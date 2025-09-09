<?php

namespace App\Filament\Pages;

use App\Models\Consultant;
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
        $internalEmployeeBirthday = [
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
            ['name' => 'Bianca Isabela Novaes Ben', 'date' => '1-Sep', 'position' => 'Funcionário'],
            ['name' => 'Mônica Anjos', 'date' => '20-Dec', 'position' => 'Prestador'],
            ['name' => 'Paulo Magalhães', 'date' => '21-Aug', 'position' => 'Prestador'],
            ['name' => 'Thiago Oliveira', 'date' => '22-Oct', 'position' => 'Prestador'],
            ['name' => 'Paola Femeninas', 'date' => '29-Mar', 'position' => 'Prestador'],
        ];

        $consultants = Consultant::select(['name', 'date_of_birth'])->get()->map(function ($consultant) {
            return [
                'name' => $consultant->name,
                'date' => $consultant->date_of_birth ? Carbon::parse($consultant->date_of_birth)->format('d-M') : null,
                'position' => 'Consultant',
            ];
        })->toArray();
        $mergeAllBirthdayData = array_merge($internalEmployeeBirthday, $consultants);

        $currentMonth = Carbon::now()->format('M');
        $birthdaysThisMonth = array_filter($mergeAllBirthdayData, function ($birthday) use ($currentMonth) {
            return $birthday['date'] && str_contains($birthday['date'], $currentMonth);
        });

        // 🔹 Sort by day within the month
        usort($birthdaysThisMonth, function ($a, $b) {
            $dayA = Carbon::createFromFormat('d-M', $a['date'])->day;
            $dayB = Carbon::createFromFormat('d-M', $b['date'])->day;
            return $dayA <=> $dayB;
        });

        return array_values($birthdaysThisMonth);
    }
}
