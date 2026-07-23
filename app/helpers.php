<?php

if (! function_exists('currentTerm')) {
    function currentTerm(): string
    {
        $now = now();
        $year = $now->year;
        $month = $now->month;

        if ($month >= 8 && $month <= 12) {
            return "Fall {$year}";
        } elseif ($month >= 1 && $month <= 4) {
            return "Spring {$year}";
        }

        return "Summer {$year}";
    }
}

if (! function_exists('currentTermLabel')) {
    function currentTermLabel(): string
    {
        $month = now()->month;

        return match (true) {
            $month >= 8 && $month <= 12 => 'Aug - Dec '.now()->year,
            $month >= 1 && $month <= 4 => 'Jan - Jun '.now()->year,
            default => 'May - Jul '.now()->year,
        };
    }
}

if (! function_exists('semesterOptions')) {
    function semesterOptions(int $pastYears = 2, int $futureYears = 2): array
    {
        $year = now()->year;
        $semesters = [];

        for ($y = $year - $pastYears; $y <= $year + $futureYears; $y++) {
            $semesters["Spring {$y}"] = "Spring {$y}";
            $semesters["Fall {$y}"] = "Fall {$y}";
        }

        return $semesters;
    }
}

if (! function_exists('semesterRange')) {
    function semesterRange(int $fromYear, int $toYear): array
    {
        $semesters = [];

        for ($y = $fromYear; $y <= $toYear; $y++) {
            $semesters["Spring {$y}"] = "Spring {$y}";
            $semesters["Fall {$y}"] = "Fall {$y}";
        }

        return $semesters;
    }
}
