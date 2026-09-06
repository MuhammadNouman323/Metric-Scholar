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

if (! function_exists('semesterPart')) {
    /**
     * Display-only semester part derived from the season of a stored term.
     */
    function semesterPart(?string $term): string
    {
        $season = explode(' ', trim((string) $term))[0] ?? '';

        return match ($season) {
            'Spring' => '1st Semester',
            'Fall' => '2nd Semester',
            'Summer' => 'Summer Semester',
            default => '',
        };
    }
}

if (! function_exists('semesterLabel')) {
    /**
     * Display label for a term, e.g. "Fall 2026 — 2nd Semester".
     * Stored values keep the plain "Fall 2026" format; this is view-level only.
     */
    function semesterLabel(?string $term): string
    {
        if (blank($term)) {
            return 'Current Semester';
        }

        return trim((string) $term);
    }
}
